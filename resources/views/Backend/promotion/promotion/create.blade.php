<x-backend.dashboard.layout>

    <x-slot:heading>
        <link href="../../../backend/css/plugins/switchery/switchery.css" rel="stylesheet">
        <link href="../../../backend/js/plugins/datetimepicker/jquery.datetimepicker.css" rel="stylesheet">
    </x-slot:heading>
    <x-slot:script>
        <script src="../../../backend/js/plugins/switchery/switchery.js"></script>
    </x-slot:script>

    @php
        $url = isset($promotion) ? route('promotion.update', $promotion->id) : route('promotion.store');
        $customerPrmotionIds = array_column(__('module.customer'), 'id');
        $promotionTypeData = [];
        $customerKeyValue =  array_column(__('module.customer'), 'name', 'id');
        $end_date = old('end_date', $promotion->end_date ?? null) ??  date('Y-m-d H:i');


        foreach ($customerPrmotionIds as $value) {
            if(isset($promotion->discount_information['apply_customer']['data']) && in_array($value,  $promotion->discount_information['apply_customer']['data'])){
                $customerTypeCondition = $promotion->discount_information['apply_customer']['condition']["customer_type_$value"];
            }
            $promotionTypeData["customer_type_$value"] = old("customer_type_$value", $customerTypeCondition ?? []) ?? [];
        }

        $productChecked = [];
        if (old('product_checked.name', $promotion->discount_information['infor']['object']['name'] ?? [])) {
            foreach (old('product_checked.name', $promotion->discount_information['infor']['object']['name'] ?? []) as $key => $value) {
                $productChecked[] = [
                    'productId' => old('product_checked.id', $promotion->discount_information['infor']['object']['id'])[$key],
                    'variantId' => old('product_checked.variant', $promotion->discount_information['infor']['object']['variant'])[$key],
                    'productName' => $value,
                ];
            }
        }

        $title = isset($promotion)
            ? __('custom.editObject', ['attribute' => __('custom.promotion')])
            : __('custom.addObject', ['attribute' => __('custom.promotion')]);

        $publish = $promotion->publish ?? '';
        $follow = $promotion->follow ?? '';
    @endphp

    <x-backend.dashboard.breadcrumb :title="$title" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <form action="{{ $url }}" method="POST" class="box" id="promotion_form">
            @csrf

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>
                                    {{ __('custom.ObjectInfor', ['attribute' => __('custom.common')]) }}
                                </h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <x-backend.dashboard.form.input inputName="name" type="text" :labelName="__('custom.name')"
                                        :must="true" rowLength="6" :value="$promotion->name ?? ''" />
                                    <x-backend.dashboard.form.input inputName="code" type="text" :labelName="__('custom.codePromotion')"
                                        rowLength="6" :value="$promotion->code ?? ''" placeholder="{{__('custom.alertCodePromotion')}}" />
                                </div>
                                <div class="row mt-10">
                                    <x-backend.dashboard.form.input inputName="description" type="text" :labelName="__('custom.description')"
                                        rowLength="12" :value="$promotion->desc ?? ''" tag="textarea" />
                                </div>
                            </div>
                        </div>

                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>
                                    {{ __('custom.configPromotionDetail') }}
                                </h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <x-backend.dashboard.form.select :labelName="__('custom.typePromotion')" name="method"
                                        :data="__('module.promotion')" :value="$promotion->method ?? ''" rowLength="12">
                                    </x-backend.dashboard.form.select>
                                </div>
                                <div class="row mt-20 show-discount-table">
                                    {{-- discount table content here --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="ibox">
                            <div class="ibox-title flex flex-col gap-10">
                                <h5>
                                    {{ __('custom.applyTime') }}
                                </h5>
                                <span id="error_datetime_message" class="error-message"
                                    hidden>{{ __('custom.alertDatetime') }}</span>

                            </div>
                            <div class="ibox-content">
                                <div class="row relative">
                                    <x-backend.dashboard.form.input class="datetimepicker" inputName="start_date"
                                        rowLength="12" type="text" :labelName="__('custom.startDate')" :value="old('start_date', $promotion->start_date ?? null) ??  date('Y-m-d H:i')"
                                        :must="true" />
                                    <span class="date-icon-right"><i class="fa fa-calendar fa-lg"></i></span>
                                </div>
                                <div class="row mt-10 relative">
                                    <x-backend.dashboard.form.input class="datetimepicker" inputName="end_date"
                                        rowLength="12" type="text" :labelName="__('custom.endDate')" :value="old('not_end_time', $promotion->not_end_time ?? null) == 'accept' ? '' : $end_date"
                                        :must="true" :disabled="old('not_end_time', $promotion->not_end_time ?? null) == 'accept'" />
                                    <span class="date-icon-right"><i class="fa fa-calendar fa-lg"></i></span>
                                </div>
                                <div class="row mt-10">
                                    <x-backend.dashboard.form.checkbox :labelName="__('custom.notEndTime')" value="accept"
                                        :checked="old('not_end_time', $promotion->not_end_time ?? null) == 'accept' ? 'checked' : ''" name="not_end_time" rowLength="12">
                                    </x-backend.dashboard.form.checkbox>
                                </div>
                            </div>
                        </div>


                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>
                                    {{ __('custom.sourceApplyFor') }}
                                </h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row flex flex-col gap-10">
                                    {{-- all source --}}
                                    <x-backend.dashboard.form.radio class="choose-source" :labelName="__('custom.applyAllSource')"
                                        value="all" name="apply_source" rowLength="12" id="all_source"
                                        :old="old('apply_source', $promotion->discount_information['apply_source']['status'] ?? null)">
                                    </x-backend.dashboard.form.radio>
                                    {{-- specific source --}}
                                    <x-backend.dashboard.form.radio class="choose-source" :labelName="__('custom.chooseSourceApply')"
                                        value="specific" name="apply_source" rowLength="12" id="specific_source"
                                        :old="old('apply_source', $promotion->discount_information['apply_source']['status'] ?? null)">
                                    </x-backend.dashboard.form.radio>
                                    {{-- select specific source --}}
                                    <x-backend.dashboard.form.multiselect :labelName="__('custom.source')" name="source"
                                        rowLength="12" :data="$sources" :value="$promotion->discount_information['apply_source']['data'] ?? []"
                                        class="multiple-select2" :hidden="old('apply_source',$promotion->discount_information['apply_source']['status'] ?? []) !== 'specific'" />
                                </div>
                            </div>
                        </div>

                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>
                                    {{ __('custom.customerTypeApplyFor') }}
                                </h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row flex flex-col gap-10">
                                    {{-- all customer --}}
                                    <x-backend.dashboard.form.radio class="choose-customer" :labelName="__('custom.applyAllCustomerType')"
                                        value="all" name="apply_customer" rowLength="12" id="all_customer"
                                        :old="old('apply_customer', $promotion->discount_information['apply_customer']['status'] ?? null)">
                                    </x-backend.dashboard.form.radio>
                                    {{-- specific customer --}}
                                    <x-backend.dashboard.form.radio class="choose-customer" :labelName="__('custom.chooseCustomerTypeApply')"
                                        value="specific" name="apply_customer" rowLength="12" id="specific_customer"
                                        :old="old('apply_customer', $promotion->discount_information['apply_customer']['status'] ?? null)">
                                    </x-backend.dashboard.form.radio>
                                    {{-- select specific customer --}}
                                    <x-backend.dashboard.form.multiselect :labelName="__('custom.customer')" name="customer_type"
                                        rowLength="12" :data="__('module.customer')" :value="$promotion->discount_information['apply_customer']['data'] ?? []"
                                        class="multiple-select2" :hidden="old('apply_customer',  $promotion->discount_information['apply_customer']['status'] ?? []) !== 'specific'" />
                                </div>
                                {{-- list choosen customer --}}
                                <div class="select-customer-type row mt-20 flex flex-col gap-10">
                                    {{-- content select here --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-space-between">
                    <a href="{{ route('promotion.index') }}" class="btn btn-danger mb-20 ">
                        {{ __('custom.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary mb-20 ">
                        {{ __('custom.save') }}
                    </button>
                </div>
        </form>
    </div>
    {{-- modal --}}
    <div id="searchProduct" class="modal fade in">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">{{ __('custom.close') }}</span>
                    </button>
                    <h4 class="modal-title">
                        {{ __('custom.attributePosDisplay', ['attribute' => __('custom.create')]) }}
                    </h4>
                    <span class="text-xs italic">{{ __('custom.chooseCurrentOrSearch') }}</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                            <input type="text" placeholder="{{ __('custom.searchByNBS') }}"
                                class="form-control search-product-variant">
                        </div>
                    </div>
                    <div class="row mt-20 choose-product-list-body px-20">
                        {{-- list product variant here --}}
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white"
                        data-dismiss="modal">{{ __('custom.cancel') }}</button>
                    <button type="button" class="btn btn-primary confirm-promotion-product-variant"
                        data-dismiss="modal">{{ __('custom.save') }}</button>
                </div>
            </div>
        </div>
    </div>{{-- !end modal --}}
    <script>
        let customerKeyValue = @json($customerKeyValue);
        let promotionTypeData = @json($promotionTypeData);
        let productTypes = @json(__('module.productType'));
        let selectedCustomerType = @json(old('customer_type', $promotion->discount_information['apply_customer']['data'] ?? []) ?? []);
        let oldPriceFrom = @json(old('promotion.price_from', $promotion->discount_information['infor']['price_from'] ?? null) ?? []);
        let oldPriceTo = @json(old('promotion.price_to', $promotion->discount_information['infor']['price_to'] ?? null) ?? []);
        let oldDiscount = @json(old('promotion.discount', $promotion->discount_information['infor']['discount'] ?? null) ?? []);
        let oldDiscountType = @json(old('promotion.discount_type', $promotion->discount_information['infor']['discount_type'] ?? null) ?? []);
        let oldProductType = @json(old('product_type', $promotion->discount_information['infor']['module_type'] ?? null) ?? '');
        let oldProductMax = @json(old('product.max', $promotion->discount_information['infor']['max_quantiy'] ?? null) ?? 0);
        let oldProductMin = @json(old('product.min', $promotion->discount_information['infor']['min_quantiy'] ?? null) ?? 1);
        let oldProductDiscount = @json(old('product.discount', $promotion->discount_information['infor']['discount'] ?? null) ?? 0);
        let oldProductDiscounttype = @json(old('product.discount_type', $promotion->discount_information['infor']['discount_type'] ?? null) ?? '');
        let productChecked = @json($productChecked);
    </script>
</x-backend.dashboard.layout>
