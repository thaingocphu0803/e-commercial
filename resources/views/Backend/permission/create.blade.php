<x-backend.dashboard.layout>

    @php
        $url = isset($permission) ? route('permission.update', $permission->id) : route('permission.store');
        $title = isset($permission) ? __('custom.editObject', ['attribute' => __('custom.permission')]) : __('custom.addObject', ['attribute' => __('custom.permission')]);
        $action = isset($permission) ? __('custom.edit') : __('custom.create');
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
                        {{__('custom.ObjectInfor', ['attribute'=> __('custom.common')])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('custom.enterPermission', ['attribute' => $action]) }}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('custom.ObjectInfor', ['attribute'=> __('custom.common')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="name" type="text" :labelName="__('custom.name')"
                                    :must="true" :value="$permission->name ?? ''" />

                                <x-backend.dashboard.form.input inputName="canonical" type="text" :labelName="__('custom.canonical')"
                                    :must="true" :value="$permission->canonical ?? ''" />
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{route('permission.index')}}" class="btn btn-success mb-20 ">
                            {{__('custom.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-primary mb-20 ">
                            {{__('custom.save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
