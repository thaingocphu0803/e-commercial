<?php

namespace App\Services;

use App\Enums\PromotionEnum;
use Illuminate\Support\Facades\DB;
use App\Repositories\PromotionRepository;
use App\Services\Interfaces\PromotionServiceInterface;
use  Illuminate\Support\Str;

/**
 * Class PromotionService
 * @package App\Services
 */
class PromotionService implements PromotionServiceInterface
{
    protected   $promotionRepository;

    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function paginate($request)
    {
        return $this->promotionRepository->paginate($request);
    }

    public function findById($id)
    {
        $promotion = $this->promotionRepository->findById($id);

        return $promotion;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only(
                'name',
                'code',
                'description',
                'method',
                'not_end_time',
                'start_date',
                'end_date',
            );

            $payload['discountValue'] = $request['product']['discount'];
            $payload['discountType'] = $request['product']['discount_type'];
            $payload['maxDiscountValue'] =  $request['product']['max'];

            if (empty($payload['code'])) {
                $payload['code'] = Str::upper(Str::random(10));
            }

            $payload['discount_information']['apply_source'] = $this->getApplySourcePayload($request->input());
            $payload['discount_information']['apply_customer'] = $this->getApplyCustomerPayload($request->input());

            switch ($payload['method']) {
                case PromotionEnum::ORDER_TOTAL_DISCOUNT:
                    $payload['discount_information']['infor'] = $request->input('promotion');
                    break;
                case PromotionEnum::PRODUCT_SPECIFIC_DISCOUNT:
                    $payload['discount_information']['infor'] = $this->getProductInforPayload($request->input());
                    break;
                default:
                    break;
            }

            $promotion = $this->promotionRepository->create($payload);

            if ($promotion->id && $payload['method'] == PromotionEnum::PRODUCT_SPECIFIC_DISCOUNT) {
                $payloadRelation = $this->getPromotionProductVariantPayload($promotion->id, $payload['discount_information']['infor']);

                $this->promotionRepository->SyncRelationPivot($promotion, $payloadRelation);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();

        try {
            $payload = $request->only(
                'name',
                'code',
                'description',
                'method',
                'not_end_time',
                'start_date',
                'end_date',
            );

            $payload['discountValue'] = $request['product']['discount'];
            $payload['discountType'] = $request['product']['discount_type'];
            $payload['maxDiscountValue'] =  $request['product']['max'];

            if(!isset($payload['not_end_time'])){
               $payload['not_end_time'] = null;
            }

            $payload['discount_information']['apply_source'] = $this->getApplySourcePayload($request->input());
            $payload['discount_information']['apply_customer'] = $this->getApplyCustomerPayload($request->input());

            switch ($payload['method']) {
                case PromotionEnum::ORDER_TOTAL_DISCOUNT:
                    $payload['discount_information']['infor'] = $request->input('promotion');
                    break;
                case PromotionEnum::PRODUCT_SPECIFIC_DISCOUNT:
                    $payload['discount_information']['infor'] = $this->getProductInforPayload($request->input());
                    break;
                default:
                    break;
            }

            if($this->promotionRepository->update($id, $payload)){
                $promotion = $this->promotionRepository->findById($id);
            };

            if ($promotion && $payload['method'] == PromotionEnum::PRODUCT_SPECIFIC_DISCOUNT) {
                $payloadRelation = $this->getPromotionProductVariantPayload($promotion->id, $payload['discount_information']['infor']);

                $this->promotionRepository->SyncRelationPivot($promotion, $payloadRelation);
            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->promotionRepository->destroy($id);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    public function forceDestroy($id)
    {
        DB::beginTransaction();
        try {
            $this->promotionRepository->forceDestroy($id);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function updateStatus($payload)
    {


        DB::beginTransaction();
        try {
            $this->promotionRepository->updateStatus($payload);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function updateStatusAll($payload)
    {

        DB::beginTransaction();
        try {
            $this->promotionRepository->updateStatusAll($payload);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    private function getApplySourcePayload($request)
    {
        $payload = [
            'status' => $request['apply_source'] ?? null,
            'data' => $request['source'] ?? []
        ];
        return $payload;
    }

    private function getApplyCustomerPayload($request)
    {
        $data = [];
        $items = [];

        if (isset($request['customer_type']) && count($request['customer_type'])) {
            $data = $request['customer_type'];
            foreach ($data as $suffix) {
                $key = "customer_type_$suffix";

                if (isset($request[$key])) {
                    $items[$key] = $request[$key];
                }
            }
        }

        $payload = [
            'status' => $request['apply_customer'] ?? null,
            'data' => $data,
            'condition' => $items
        ];

        return $payload;
    }

    private function getProductInforPayload($request)
    {
        $payload = [
            'min_quantiy' => $request['product']['min'],
            'max_quantiy' => $request['product']['max'],
            'discount' => $request['product']['discount'],
            'discount_type' => $request['product']['discount_type'],
            'module_type' => $request['module_type'],
            'object' => $request['product_checked'] ?? []
        ];

        return $payload;
    }

    private function getPromotionProductVariantPayload($promotion_id, $request)
    {
        $objectVariant = $request['object']['variant'];
        $objectId = $request['object']['id'];
        $payload = [];
        if (count($objectVariant)) {
            foreach ($objectVariant as $key => $val) {
                $payload[] = [
                    'promotion_id' => $promotion_id,
                    'product_id' => $objectId[$key],
                    'variant_uuid' => $val,
                    'model' => $request['module_type']
                ];
            }
        }

        return $payload;
    }
}
