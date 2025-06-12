<x-backend.dashboard.layout>

    <x-backend.dashboard.breadcrumb :title="__('custom.menulist')" />
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-title">{{ __('custom.menulist') }}</div>
                <div class="panel-description">
                    <p>{{ __('custom.desUpdateMenu') }}</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-title flex flex-space-between flex-middle">
                        <h5>{{ __('custom.mainMenu') }}</h5>
                        <a href="{{route('menu.edit.parentMenu', $menu_catalouge_id)}}" class="custom-button italic text-bold text-sm">{{ __('custom.editMenu') }}</a>
                    </div>
                    <div class="ibox-content">
                        <div class="dd" id="nestable2">
                            <x-backend.menu.menu.nestable :trees="$trees" />
                        </div>

                        <div class="m-t-md" hidden>
                            <h5>Serialised Output</h5>
                            <textarea id="nestable2-output" class="form-control"></textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-backend.dashboard.layout>
