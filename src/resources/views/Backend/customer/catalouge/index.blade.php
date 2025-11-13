<x-backend.dashboard.layout>
    <div class="row wrapper border-bottom white-bg page-heading">
        <x-backend.dashboard.breadcrumb :title="__('custom.managerObject', ['attribute' => __('custom.customerCatalouge')])"/>

        <div class="col-lg-2">
        </div>
        <div class="col-lg-12 mt-20">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ __('custom.listObject', ['attribute' => __('custom.customerCatalouge')]) }}</h5>
                    <x-backend.dashboard.toolbox model="customerCatalouge" object="customerCatalouge"/>
                </div>
                <div class="ibox-content">
                    <x-backend.customer.catalouge.filter/>
                    <x-backend.customer.catalouge.table :customerCatalouges="$customerCatalouges" />
                </div>
            </div>
        </div>
    </div>


</x-backend.dashboard.layout>
