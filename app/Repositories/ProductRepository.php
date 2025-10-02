<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductCatalouge;
use App\Models\ProductLanguage;
use App\Models\ProductVariant;
use App\Models\Promotion;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function getByVariant($payload)
    {
        $product_id = $payload['product_id'];
        $code = $payload['code'];
        $publish = config('app.general.defaultPublish');

        $productData = ProductVariant::select(
            'product_variants.id',
            'product_variants.product_id',
            'product_variants.album',
            'product_variants.price',
            'product_variants.uuid',
            'p.maxDiscountValue',
            'p.discountType',
            'p.discountValue',
            DB::raw("
                IF( p.maxDiscountValue != 0,
                    LEAST(
                        CASE
                            WHEN p.discountType='amount' THEN p.discountValue
                            WHEN p.discountType='percent' THEN product_variants.price * (p.discountValue/100)
                            ELSE 0
                        END,
                        p.maxDiscountValue
                        ),
                    CASE
                        WHEN p.discountType='amount' THEN p.discountValue
                        WHEN p.discountType='percent' THEN  product_variants.price * (p.discountValue/100)
                    ELSE 0
                    END
                ) as discount
            ")
        )
            ->leftJoin('promotion_product_variant as ppv', 'ppv.variant_uuid', '=', 'product_variants.uuid')
            ->leftJoin('promotions as p', function ($join) use ($publish) {
                $join->on('ppv.variant_uuid', '=', 'product_variants.uuid')
                    ->where('p.publish', '=', $publish)
                    ->where(function ($q) {
                        $q->whereNull('p.end_date')
                        ->orWhere('p.end_date', '>', now());
                    });
            })
            ->where('product_variants.publish', $publish)
            ->where('product_variants.code', $code)
            ->where('product_variants.product_id', $product_id)
            ->orderBy('discount', 'desc')
            ->limit(1)
            ->get();

        if (!count($productData)) return false;

        $productData = $productData->first()->toArray();



        if (!empty($productData['album'])) {
            $album = explode(',', $productData['album']);
            $productData['image'] =  base64_encode($album[0]);
            $productData['album'] = array_slice($album, 1, 4);
        }else{
            $productData['image'] = null;
            $productData['album'] = null;
        }

        if($productData['discount'] && $productData['discount'] > 0){
            $productData['discounted_price'] = $productData['price'] - $productData['discount'];
        }

        return $productData;
    }

    public function getWithVariant($payload)
    {
        $publish = config('app.general.defaultPublish');

        $uuid = $payload['uuid'];

        $promotion_id = $payload['promotion_id'];

        $product_id = $payload['product_id'];

        $product_attrs = ProductVariant::select('pva.attr_id')
            ->distinct()
            ->join('product_variant_attr as pva', 'pva.product_variant_id', '=', 'product_variants.id')
            ->where('product_variants.product_id',  $product_id)
            ->get()
            ->pluck('attr_id')
            ->toArray();

        $promotion = Promotion::select('discountValue', 'discountType', 'maxDiscountValue')
            ->publish($publish)
            ->find($promotion_id);

        $productByCondition = Product::select('products.id', 'pl.name', 'pl.description', 'products.image', 'products.album', 'products.price')
            ->with(['productCatalouges' => function ($productCatalouges) use ($publish) {
                $productCatalouges->select('product_catalouges.id', 'pcl.product_catalouge_id', 'pcl.name as product_catalouge_name', 'pcl.canonical as product_catalouge_canonical')
                    ->join('product_catalouge_language as pcl', 'pcl.product_catalouge_id', '=', 'product_catalouges.id')
                    ->publish($publish);
            }]);

        if (!is_null($uuid)) {
            $productByCondition = $productByCondition->with([
                'productVariants' => function ($productVariant) use ($publish, $uuid) {
                    $productVariant->with(['attrs.attrCatalouges' => function ($attrCatalouge) use ($publish) {
                        $attrCatalouge->with(['attrs' => function ($attrs) use ($publish) {
                            $attrs->select('attrs.id', 'al.name', 'al.canonical')
                                ->join('attr_language as al', 'al.attr_id', '=', 'attrs.id')
                                ->publish($publish);
                        }])
                            ->select('attr_catalouges.id', 'acl.name', 'acl.canonical', 'attr_catalouges.id')
                            ->join('attr_catalouge_language as acl', 'acl.attr_catalouge_id', '=', 'attr_catalouges.id')
                            ->publish($publish);
                    }])
                        ->select('product_variants.id', 'product_variants.product_id', 'product_variants.price', 'product_variants.album', 'product_variants.code')
                        ->where('product_variants.uuid', $uuid)->first();
                }
            ]);
        }

        $productByCondition = $productByCondition->join('product_language as pl', 'pl.product_id', '=', 'products.id')
            ->where('id', $product_id)
            ->publish($publish)
            ->get()
            ->first();

        if (empty($productByCondition)) return false;

        $productData['id'] = $productByCondition->id;
        $productData['name'] = $productByCondition->name;
        $productData['description'] = $productByCondition->description;
        $productData['image'] = $productByCondition->image;
        $productData['album'] = !is_null($productByCondition->album) ? array_slice(json_decode($productByCondition->album, true), 0, 4) : null;
        $productData['price'] = $productByCondition->price;
        $productData['catalouges'] = $productByCondition->productCatalouges->toArray();

        if (!empty($productByCondition->productVariants->first())) {
            $productData['price'] = $productByCondition->productVariants->first()->price;
            $productData['variant_id'] = $productByCondition->productVariants->first()->id;
            $productData['variant_codes'] =  explode('-', $productByCondition->productVariants->first()->code);

            $album = $productByCondition->productVariants->first()->album;
            if (!isEmpty($album)) {
                $album = explode(',', $album);
                $productData['image'] =  $album[0];
                $productData['album'] = array_slice($album, 1, 4);
            }

            $attrCatalouges = $productByCondition->productVariants->first()->attrs->pluck('attrCatalouges');

            $productData['attrCatalouges'] = $attrCatalouges->map(function ($catalouge) {
                return [
                    'attr_catalouge_id' => $catalouge->first()->id,
                    'attr_catalouge_name' => $catalouge->first()->name,
                    'attr_catalouge_canonical' => $catalouge->first()->canonical,
                    'attrs' => $catalouge->first()->attrs->toArray()
                ];
            })->toArray();
        }

        if (!empty($promotion)) {
            $discount = 0;
            if ($promotion->maxDiscountValue > 0) {
                $discount = $promotion->maxDiscountValue;
            } else {
                if ($promotion->discountType === 'amount') {
                    $discount = $promotion->discountValue;
                } else if ($promotion->discountType === 'percent') {
                    $discount =  $productData['price'] *  ($promotion->discountValue / 100);
                }
            }

            $productData['discounted_price'] = $productData['price'] - $discount;
        }

        $productData['attrs'] = $product_attrs;
        return $productData;
    }

    public function getWithPromotion($product_catalouge_id)
    {
        $extraCondition = (!is_null($product_catalouge_id)) ? "AND pcl.product_catalouge_id = $product_catalouge_id" : "";

        $publish = config('app.general.defaultPublish');

        $promotionSub = Promotion::select(
            'promotions.id',
            'ppv.product_id',
            'ppv.variant_uuid as uuid',
            'promotions.discountValue',
            'promotions.discountType',
            'promotions.maxDisCountValue',
        )
            ->join('promotion_product_variant as ppv', 'promotions.id', '=', 'ppv.promotion_id')
            ->where('ppv.model', 'product')
            ->publish($publish)
            ->where(function ($q) {
                $q->whereNull('promotions.end_date')
                    ->orWhere('promotions.end_date', '>', now());
            });

        $products = DB::table(DB::raw(
            "(
            SELECT
                products.id,
                pv.uuid,
                ps.id as promotion_id,
                products.image,
                products.album,
                products.code,
                pl.name as product_name,
                pcl.name as product_catalouge_name,
                pcl.canonical as product_catalouge_canonical,
                pl.canonical as product_canonical,
                ps.discountValue,
                ps.discountType,
                ps.maxDiscountValue,
                COALESCE(pv.price, products.price) as product_price,
                (
                    IF(
                        ps.maxDiscountValue != 0,
                        LEAST(
                            CASE
                                WHEN ps.discountType='amount' THEN ps.discountValue
                                WHEN ps.discountType='percent' THEN COALESCE(pv.price, products.price) * (ps.discountValue/100)
                                ELSE 0
                            END,
                            ps.maxDiscountValue
                        ),
                        CASE
                            WHEN ps.discountType='amount' THEN ps.discountValue
                            WHEN ps.discountType='percent' THEN COALESCE(pv.price, products.price) * (ps.discountValue/100)
                            ELSE 0
                        END
                    )
                ) as discount,

                ROW_NUMBER() OVER (PARTITION BY products.id ORDER BY
                    (
                        COALESCE(pv.price, products.price) -
                        IF(
                            ps.maxDiscountValue != 0,
                            LEAST(
                                CASE
                                    WHEN ps.discountType='amount' THEN ps.discountValue
                                    WHEN ps.discountType='percent' THEN COALESCE(pv.price, products.price) * (ps.discountValue/100)
                                    ELSE 0
                                END,
                                ps.maxDiscountValue
                            ),
                            CASE
                                WHEN ps.discountType='amount' THEN ps.discountValue
                                WHEN ps.discountType='percent' THEN COALESCE(pv.price, products.price) * (ps.discountValue/100)
                                ELSE 0
                            END
                        )
                    ) ASC
                ) as rn

                FROM products
                JOIN product_language as pl ON products.id = pl.product_id
                JOIN product_catalouge_language as pcl ON products.product_catalouge_id = pcl.product_catalouge_id
                {$extraCondition}
                LEFT JOIN product_variants as pv ON products.id = pv.product_id
                LEFT JOIN (
                    {$promotionSub->toSql()}
                    ) as ps ON ps.product_id = products.id
                    AND (ps.uuid = pv.uuid OR (ps.uuid IS NULL AND pv.uuid IS NULL))
                WHERE products.publish = $publish
            ) as ranked"
        ))
            ->mergeBindings($promotionSub->getQuery())
            ->where('rn', 1)
            ->paginate(10);

        return $products;
    }

    public function getToTree()
    {
        $productCatalouges = ProductCatalouge::with('languages')->orderBy('_lft', 'asc')->get();

        $productCatalouges = $productCatalouges->map(function ($product) {
            if ($product->languages->isNotEmpty()) {
                $product['name'] = $product->languages->first()->pivot->name;
            }
            return $product;
        });

        return $productCatalouges->toTree();
    }

    public function findById($id)
    {
        $product = Product::with([
            'languages',
            'productCatalouges',
            'productVariants' => function ($q) {
                $q->with(['attrs' => function ($q) {
                    $q->with(['attrLanguage']);
                }]);
            }
        ])->findOrFail($id);


        if ($product->languages->isEmpty()) {
            return false;
        }

        $pivot = $product->languages->first()->pivot;
        $pivot['product_catalouge_id'] = $product->product_catalouge_id;
        $pivot['publish'] = $product->publish;
        $pivot['code'] = $product->code;
        $pivot['price'] = $product->price;
        $pivot['follow'] = $product->follow;
        $pivot['image'] = $product->image;
        $pivot['album'] = $product->album;
        $pivot['catalouges'] = $product->productCatalouges
            ->pluck('pivot.product_catalouge_id')
            ->toArray();

        if (count($product->productVariants)) {
            $attr_catalouge = explode('-', $product->productVariants->first()->attr_catalouge);
            foreach ($product->productVariants as $variant) {
                $attr = explode('-', $variant->code);

                foreach ($attr_catalouge as $key => $val) {
                    $attributes[$val][] = $attr[$key];
                }

                $detail['quantity'][] = $variant->quantity;
                $detail['sku'][] = $variant->sku;
                $detail['price'][] = $variant->price;
                $detail['barcode'][] = $variant->barcode;
                $detail['filename'][] = $variant->filename;
                $detail['url'][] = $variant->url;
                $detail['album'][] = $variant->album;
            }

            foreach ($attributes as $key => $val) {
                $attributes[$key] = array_values((array_unique($val)));
            }

            $pivot['variants'] = [
                'attr_catalouge' => $attr_catalouge,
                'attributes' => $attributes,
                'detail' => $detail,

            ];
        }

        return  $pivot;
    }

    public function findPivotById($id)
    {
        return Product::with([
            'languages',
            'productCatalouges',
            'productVariants' => function ($q) {
                $q->with(['attrs' => function ($q) {
                    $q->with(['attrLanguage']);
                }]);
            }
        ])->findOrFail($id);
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');
        $product_catalouge_id = $request->input('product_catalouge_id');

        $query =  Product::with('productCatalouges.languages')->select(
            'products.id as id',
            'products.image as image',
            'pl.name as name',
            'pl.canonical as canonical',
            'products.publish as publish',
            'products.order as order'
        )
            ->join('product_language as pl', 'pl.product_id', '=', 'products.id')
            ->join('product_catalouge_product as pcp', 'pcp.product_id', '=', 'products.id')
            ->keyword($keyword ?? null)
            ->publish($publish ?? null);

        if (!empty($product_catalouge_id)) {
            $catalouges = $this->getDescendantsAndSelf($product_catalouge_id);
            if (!empty($catalouges)) {
                $query->WhereIn('products.product_catalouge_id', $catalouges);
            }
        }

        return $query->distinct()->paginate($perpage)->withQueryString();
    }

    public function getDescendantsAndSelf($id)
    {
        return ProductCatalouge::descendantsAndSelf($id)->pluck('id');
    }

    public function create($payload)
    {
        return Product::create($payload);
    }

    public function createLanguagePivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    public function createCatalougePivot($model, $payload = [])
    {
        return $model->productCatalouges()->sync($payload);
    }

    public function updateCatalougePivot($id, $payload = [])
    {
        return Product::find($id)->productCatalouges()->sync($payload);
    }


    public function update($id, $payload)
    {
        return Product::find($id)->update($payload);
    }

    public function updateProductLanguage($id, $payload = [])
    {
        return ProductLanguage::where('product_id', $id)
            ->update($payload);
    }

    public function destroy($id)
    {
        return Product::destroy($id);
    }


    public function forceDestroy($id)
    {
        return Product::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return Product::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return Product::whereIn('id', $ids)->update($columm);
    }

    public function loadProductWithVariant($request)
    {
        $keyword = $request->input('keyword');

        return Product::selectRaw(
            "
                products.id,
                products.image,
                tb3.uuid as variant_uuid,
                CONCAT(tb2.name, ' | ', COALESCE(tb3.name, 'default')) as product_name,
                COALESCE(tb3.sku, products.code) as sku,
                COALESCE(tb3.price, products.price) as price
            "
        )
            ->join('product_language as tb2', 'products.id', '=', 'tb2.product_id')
            ->leftJoin('product_variants as tb3', 'products.id', '=', 'tb3.product_id')
            ->where('tb2.name', 'like', '%' . $keyword . '%')
            ->paginate(10)->withQueryString();
    }
}
