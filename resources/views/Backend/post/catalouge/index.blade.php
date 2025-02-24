<x-backend.dashboard.layout>
    <div class="row wrapper border-bottom white-bg page-heading">
        <x-backend.dashboard.breadcrumb title="Manager Post Group"/>

        <div class="col-lg-2">
        </div>
        <div class="col-lg-12 mt-20">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>List Post Group </h5>
                    <x-backend.dashboard.toolbox model="postCatalouge" object="postCatalouge"/>
                </div>
                <div class="ibox-content">
                    <x-backend.post.catalouge.filter/>
                    <x-backend.post.catalouge.table :postCatalouges="$postCatalouges" />
                </div>
            </div>
        </div>
    </div>


</x-backend.dashboard.layout>
