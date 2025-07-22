<x-backend.dashboard.layout>
    <div class="row wrapper border-bottom white-bg page-heading">
        <x-backend.dashboard.breadcrumb :title="__('custom.managerObject', ['attribute' => __('custom.source')])"/>

        <div class="col-lg-2">
        </div>
        <div class="col-lg-12 mt-20">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ __('custom.listObject', ['attribute' => __('custom.source')]) }}</h5>
                    <x-backend.dashboard.toolbox model="source" object="source"/>
                </div>
                <div class="ibox-content">
                    <x-backend.promotion.source.filter/>
                    <x-backend.promotion.source.table :sources="$sources" />
                </div>
            </div>
        </div>
    </div>


</x-backend.dashboard.layout>
