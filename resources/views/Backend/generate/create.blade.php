<x-backend.dashboard.layout>

    @php
        $url = isset($generate) ? route('generate.update', $generate->id) : route('generate.store');
        $title = isset($generate) ? __('form.editObject', ['attribute' => __('dashboard.generate')]) : __('form.addObject', ['attribute' => __('dashboard.generate')]);
        $action = isset($generate) ? __('form.edit') : __('form.create');
    @endphp

    <x-backend.dashboard.breadcrumb :title="$title" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <form action="{{ $url }}" method="POST" class="box">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('form.ObjectInfor', ['attribute'=> __('form.common')])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('form.enterLanguage', ['attribute' => $action]) }}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.ObjectInfor', ['attribute'=> __('form.common')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input
                                    inputName="name"
                                    type="text"
                                    :labelName="__('dashboard.modelName')"
                                    :must="true"
                                    :value="$generate->name ?? ''"
                                    placeholder="example: product"

                                />
                                <x-backend.dashboard.form.input
                                inputName="module_icon"
                                type="text"
                                :labelName="__('dashboard.moduleIcon')"
                                :must="true"
                                :value="$generate->module ?? ''"
                                placeholder="example: fa-icon"
                            />
                            </div>
                            {{-- <div class="row mt-20">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="module_type" class="control-label text-left">
                                            {{__('form.typeModule')}}
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select name="module_type" id="module_type" class="select2 form-control">
                                            <option disabled selected>{{__('form.chooseObject', ['attribute' => __('form.module')])}}</option>
                                            <option value="1" @selected(old('module_type') == 1)>{{__('form.moduleSection')}}</option>
                                            <option value="2" @selected(old('module_type') == 2)>{{__('form.moduleDetail')}}</option>
                                            <option value="3" @selected(old('module_type') == 3)>{{__('form.moduleOther')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('form.ObjectInfor', ['attribute'=> __('form.common')])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('form.enterLanguage', ['attribute' => $action]) }}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.ObjectInfor', ['attribute'=> __('form.schemaCatalouge')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input
                                    inputName="schema_catalouge"
                                    type="text"
                                    :labelName="__('dashboard.schemaCatalouge')"
                                    :must="true"
                                    :value="$generate->name ?? ''"
                                    rowLength="12"
                                    tag="textarea"
                                    style="height: 250px"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.ObjectInfor', ['attribute'=> __('form.schemaDetail')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input
                                    inputName="schema_detail"
                                    type="text"
                                    :labelName="__('dashboard.schemaDetail')"
                                    :must="true"
                                    :value="$generate->name ?? ''"
                                    rowLength="12"
                                    tag="textarea"
                                    style="height: 250px"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{route('generate.index')}}" class="btn btn-success mb-20 ">
                            {{__('form.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-primary mb-20 ">
                            {{__('form.save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
