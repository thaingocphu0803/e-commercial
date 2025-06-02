<x-backend.dashboard.layout>
    <div class="row wrapper border-bottom white-bg page-heading">
        <x-backend.dashboard.breadcrumb :title="__('custom.managerObject', ['attribute' => __('custom.language')])"/>

        <div class="col-lg-2">
        </div>
        <div class="col-lg-12 mt-20">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ __('custom.listObject', ['attribute' => __('custom.language')]) }}</h5>
                    <x-backend.dashboard.toolbox model="Language" object="languages"/>
                </div>
                <div class="ibox-content">
                    <x-backend.language.filter/>
                    <x-backend.language.table :languages="$languages" />
                </div>
            </div>
        </div>
    </div>


</x-backend.dashboard.layout>
