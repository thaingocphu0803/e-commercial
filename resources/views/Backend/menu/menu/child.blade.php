<x-backend.dashboard.layout>

    <x-backend.dashboard.breadcrumb :title="__('custom.saveChildMenu')" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php

        $route = isset($parentId)
            ? route('menu.child.save', $parentId)
            : route('menu.parent.save', $parent_menu_catalouge_id);
    @endphp
    <form action="{{ $route }}" method="POST" class="box">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
            @if (!isset($parentId))
                <div class="row">
                    <div class="col-lg-5">
                        <h3 class="panel-title">
                            {{ __('custom.ObjectInfor', ['attribute' => __('custom.posMenu')]) }}
                        </h3>
                        <div class="pannel-description">
                            {{ __('custom.notePosMenu') }}
                        </div>

                    </div>
                    <div class="col-lg-7">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>
                                    {{ __('custom.ObjectInfor', ['attribute' => __('custom.posMenu')]) }}
                                </h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <x-backend.dashboard.form.select :labelName="__('custom.posMenu')" name="menu_catalouge_id"
                                        :data="$menuCatalouges" :must="true" :value="$parent_menu_catalouge_id ?? ''" rowLength="12">
                                    </x-backend.dashboard.form.select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-5">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="panel-body">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <span class="panel-title text-sm">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                    href="#collapseOne">{{ __('custom.customLink') }}</a>
                                            </span>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="text-sm italic text-danger">
                                                    <li>{{ __('custom.noteAddMenu1') }}</li>
                                                    <li>{{ __('custom.noteAddMenu2') }}</li>
                                                    <li>{{ __('custom.noteAddMenu3') }}</li>
                                                </ul>
                                                <button type="button"
                                                    class="text-capitalize btn btn-secondary menu_row_add_btn">
                                                    {{ __('custom.addLink') }}
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                    @foreach (__('module.module') as $key => $val)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <span class="panel-title text-sm">
                                                    <a class="menu-model" data-toggle="collapse"
                                                        data-parent="#accordion" href="#{{ $key }}"
                                                        data-model="{{ $key }}">{{ $val }}</a>
                                                </span>
                                            </div>
                                            <div id="{{ $key }}" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <form action="" method="GET"
                                                        data-model="{{ $key }}" class="search-model">
                                                        <input type="text" value=""
                                                            data-model="{{ $key }}"
                                                            class="form-control search-menu" name="keyword"
                                                            placeholder="{{ __('custom.2findPlaceHolder') }}"
                                                            autocomplete="off">
                                                    </form>
                                                    <div class="menu-list mt-10">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-4 text-center">
                                    <label class="text-capitalize">{{ __('custom.menuName') }}</label>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <label class="text-capitalize">{{ __('custom.link') }}</label>

                                </div>
                                <div class="col-lg-2 text-center">
                                    <label class="text-capitalize">{{ __('custom.position') }}</label>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="menu-wrapper">
                                <div class="text-center menu_row_notification {{ old('menu', $menuArr) ? 'hidden' : '' }}">
                                    <h4>{{ __('custom.descLinkList') }}</h4>
                                    <span>{{ __('custom.guideLinkList') }}</span>
                                </div>
                            </div>
                            @if (!empty(old('menu', $menuArr)))
                                @foreach (old('menu', $menuArr)['name'] as $key => $value)
                                    @php
                                        $data = [
                                            'name' => old('menu', $menuArr)['name'][$key],
                                            'canonical' => old('menu', $menuArr)['canonical'][$key],
                                            'position' => old('menu', $menuArr)['position'][$key],
                                            'id' => old('menu', $menuArr)['id'][$key],
                                        ];
                                    @endphp
                                    <div
                                        class="row mt-20 menu-row menu-row-{{ old('menu', $menuArr)['canonical'][$key] }}">
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" value="{{ $data['name'] }}"
                                                name="menu[name][]">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" value="{{ $data['canonical'] }}"
                                                name="menu[canonical][]">
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="int" class="form-control text-right"
                                                value="{{ $data['position'] }}" name="menu[position][]">
                                        </div>
                                        <div class="col-lg-2 flex flex-center flex-middle">
                                            <a href="#" class="delete-menu-row text-danger">
                                                <i class="fa fa-times fa-2x"></i>
                                            </a>
                                            <input type="" name="menu[id][]" value="{{ $data['id'] }}"
                                                hidden>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-space-between">
                <a href="{{ route('menu.edit', $parent_menu_catalouge_id) }}"
                    class="btn btn-success mb-20 ">{{ __('custom.cancel') }}</a>
                <button type="submit"
                    class="btn btn-primary mb-20">{{ __('custom.save') }}</button>
            </div>
    </form>
    <script>
        const listChoosenMenu = @json(old('menu', $menuArr)['canonical'] ?? []);
    </script>
</div>
</x-backend.dashboard.layout>
