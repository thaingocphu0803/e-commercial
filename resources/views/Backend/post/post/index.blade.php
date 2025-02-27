<x-backend.dashboard.layout>
    <div class="row wrapper border-bottom white-bg page-heading">
        <x-backend.dashboard.breadcrumb title="Manager Post"/>

        <div class="col-lg-2">
        </div>
        <div class="col-lg-12 mt-20">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>List Post </h5>
                    <x-backend.dashboard.toolbox model="post" object="post"/>
                </div>
                <div class="ibox-content">
                    <x-backend.post.post.filter/>
                    <x-backend.post.post.table :posts="$posts" />
                </div>
            </div>
        </div>
    </div>


</x-backend.dashboard.layout>
