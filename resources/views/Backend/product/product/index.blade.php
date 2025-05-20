<x-backend.dashboard.layout>
    <div class="row wrapper border-bottom white-bg page-heading">
        <x-backend.dashboard.breadcrumb :title="__('dashboard.managerObject', ['object' => __('dashboard.product')])"/>

        <div class="col-lg-2">
        </div>
        <div class="col-lg-12 mt-20">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ __('table.listObject', ['attribute' => __('dashboard.product')]) }}</h5>
                    <x-backend.dashboard.toolbox model="product" object="product"/>
                </div>
                <div class="ibox-content">
                    <x-backend.product.product.filter :listNode="$listNode"/>
                    <x-backend.product.product.table :products="$products" />
                </div>
            </div>
        </div>
    </div>


</x-backend.dashboard.layout>
