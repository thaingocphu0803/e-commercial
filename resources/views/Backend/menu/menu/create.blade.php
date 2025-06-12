<x-backend.dashboard.layout>

    <x-backend.dashboard.breadcrumb :title="__('custom.addObject', ['attribute' => __('custom.menu')])" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="row">
    <form action="{{ route('menu.store') }}" method="POST" class="box">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
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
                                    :data="$menuCatalouges" :must="true" :value="$menu->id ?? ''" rowLength="12">
                                    <button type="button" class="btn btn-danger text-capitalize" data-toggle="modal"
                                        data-target="#createMenuCatalouge">
                                        {{ __('custom.attributePosDisplay', ['attribute' => __('custom.create')]) }}
                                    </button>
                                </x-backend.dashboard.form.select>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-12">
                                    <div class="form-row">
                                        <label for=""
                                            class="control-label text-right text-capitalize">{{ __('custom.menuType') }}</label>
                                        <select class="form-control select2" name="menu_type" id="menu_type">
                                            <option selected disabled>
                                                {{ __('custom.choose') . ' ' . __('custom.menuType') }}</option>
                                            @foreach (__('module.type') as $key => $val)
                                                <option {{ old('menu_type') == $key ? 'selected' : '' }}
                                                    value="{{ $key }}">{{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                <div class="text-center menu_row_notification {{ old('menu') ? 'hidden' : '' }}">
                                    <h4>{{ __('custom.descLinkList') }}</h4>
                                    <span>{{ __('custom.guideLinkList') }}</span>
                                </div>
                            </div>
                            @if (!empty(old('menu')))
                                @foreach (old('menu')['name'] as $key => $value)
                                    @php
                                        $data = [
                                            'name' => old('menu')['name'][$key],
                                            'canonical' => old('menu')['canonical'][$key],
                                            'position' => old('menu')['position'][$key],
                                        ];
                                    @endphp
                                    <div class="row mt-20 menu-row menu-row-{{ old('menu')['canonical'][$key] }}">
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
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-space-between">
                <a href="{{ route('menu.index') }}" class="btn btn-success mb-20 ">{{ __('custom.cancel') }}</a>
                <button type="submit"
                    class="btn btn-primary mb-20">{{ __('custom.save') }}</button>
            </div>
    </form>
</div>
    {{-- modal --}}
    <div id="createMenuCatalouge" class="modal fade in">
        <form action="" method="POST" class="form create-menu-catalouge">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">
                            {{ __('custom.attributePosDisplay', ['attribute' => __('custom.create')]) }}
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <x-backend.dashboard.form.input :labelName="__('custom.posMenu')" inputName="menu_catalouge_name"
                                type="text" :value="''" rowLength="12" :must="true">
                                <span class="error-message" id="error_menu_catalouge_name"></span>
                            </x-backend.dashboard.form.input>
                        </div>
                        <div class="row mt-20">
                            <x-backend.dashboard.form.input :labelName="__('custom.keyword')" inputName="menu_catalouge_keyword"
                                type="text" :value="''" rowLength="12" :must="true">
                                <span class="error-message" id="error_menu_catalouge_keyword"></span>
                            </x-backend.dashboard.form.input>
                        </div>
                        <div class="row mt-10 text-center">
                            <span id="create_menu_catalouge_message" class="italic text-bold text-sm"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white"
                            data-dismiss="modal">{{ __('custom.cancel') }}</button>
                        <button type="button" class="btn btn-primary create_menu_catalouge_btn">{{ __('custom.save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>{{-- !end modal --}}
    <script>
        const lang = "{{ app()->getLocale() }}";
        const listChoosenMenu = @json(old('menu')['canonical'] ?? []);
    </script>

</x-backend.dashboard.layout>
