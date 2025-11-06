<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\AttrService;
use Illuminate\Http\Request;

class AttrController extends Controller
{
    private $attrService;
    public function __construct(AttrService $attrService)
    {
        $this->attrService = $attrService;
    }

    public function getAttr(Request $request)
    {
        $payload = $request->input();
        $attrs = $this->attrService->searchAttr($payload['search'], $payload['option']);

        $attrMap = $attrs->map(function ($attr) {
            return [
                'id' => $attr->id,
                'text' => $attr->attr_name
            ];
        })->all();

        return response()->json([
            'items' => $attrMap
        ]);
    }

    public function loadAttr(Request $request)
    {
        $payload['attributes'] = $request->input('attributes');
        $payload['attrCatalougeId'] = $request->input('attrCatalougeId');
        $attributeArray =  $payload['attributes'][$payload['attrCatalougeId']];
        $attributes = [];
        if (count($attributeArray) > 0) {
            $attributes = $this->attrService->findAttrByIdArr($attributeArray);
        }

        $temp = [];

        if (count($attributes) > 0) {
            foreach ($attributes as $attr) {
                $temp[] = [
                    'id' => $attr->id,
                    'name' => $attr->attr_name
                ];
            }
        }


        return response()->json([
            'items' => $temp
        ]);
    }
}
