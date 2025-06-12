<x-backend.dashboard.layout>
    <div class="row wrapper border-bottom white-bg page-heading">
        <x-backend.dashboard.breadcrumb :title="__('custom.managerObject', ['attribute' => __('custom.member')])"/>

        <div class="col-lg-2">
        </div>
        <div class="col-lg-12 mt-20">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ __('custom.listObject', ['attribute' => __('custom.slides')]) }}</h5>
                    <x-backend.dashboard.toolbox model="Slide" object="Slide"/>
                </div>
                <div class="ibox-content">
                    <x-backend.slide.slide.filter :slides="$slides"/>
                    <x-backend.slide.slide.table :slides="$slides"/>
                </div>
            </div>
        </div>
    </div>


</x-backend.dashboard.layout>
