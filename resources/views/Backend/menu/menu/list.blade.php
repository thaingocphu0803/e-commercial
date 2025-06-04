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
                        <a href="" class="custom-button italic text-bold text-sm">{{ __('custom.editMenu') }}</a>
                    </div>
                    <div class="ibox-content">
                        <div class="dd" id="nestable2">
                            <ol class="dd-list">
                                @foreach ($menus as $key => $val)
                                    <li class="dd-item" data-id="{{ $key }}">
                                        <div class="dd-handle">
                                            <span class="label label-info"><i class="fa fa-arrows"></i></span>
                                            <span>{{ $val }}</span>
                                        </div>
                                        <a href="{{route('menu.child.index', $key)}}" class="to-child-menu">{{__('custom.manageChildMenu')}}</a>

                                        <ol class="dd-list">
                                            <li class="dd-item" data-id="2">
                                                <div class="dd-handle">
                                                    <span class="pull-right"> 12:00 pm </span>
                                                    <span class="label label-info"><i class="fa fa-arrows"></i></span>
                                                    Vivamus vestibulum nulla nec ante.
                                                </div>
                                            </li>
                                            <li class="dd-item" data-id="3">
                                                <div class="dd-handle">
                                                    <span class="pull-right"> 11:00 pm </span>
                                                    <span class="label label-info"><i class="fa fa-arrows"></i></span>
                                                    Nunc dignissim risus id metus.
                                                </div>
                                            </li>
                                            <li class="dd-item" data-id="4">
                                                <div class="dd-handle">
                                                    <span class="pull-right"> 11:00 pm </span>
                                                    <span class="label label-info"><i class="fa fa-arrows"></i></span>
                                                    Vestibulum commodo
                                                </div>
                                            </li>
                                        </ol>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                        <div class="m-t-md">
                            <h5>Serialised Output</h5>
                        </div>
                        <textarea id="nestable2-output" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-backend.dashboard.layout>
