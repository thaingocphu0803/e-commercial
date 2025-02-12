<x-backend.dashboard.layout>
    <div class="row wrapper border-bottom white-bg page-heading">
        <x-backend.dashboard.breadcrumb title="Manage Member"/>

        <div class="col-lg-2">
        </div>
        <div class="col-lg-12 mt-20">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>List Member </h5>
                    <x-backend.user.toolbox/>
                </div>
                <div class="ibox-content">
                    <x-backend.user.filter/>
                    <x-backend.user.table :users="$users"/>
                </div>
            </div>
        </div>
    </div>


</x-backend.dashboard.layout>
