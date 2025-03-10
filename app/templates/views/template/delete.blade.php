<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb
        :title="__('form.delObject', ['attribute'=>__('dashboard.{module}')])"
    />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('{routerPath}.destroy', ${moduleName}->{moduleTableName}_id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('form.ObjectInfor', ['attribute' => __('dashboard.{module}')])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('form.DelQuestion', ['attribute' => __('dashboard.{module}')])}}
                        <span class="text-danger">{{ ${moduleName}->name }}</span>
                    </div>
                    <div class="pannel-description">{{__('form.DelNote')}}</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="name" type="text" :labelName="__('dashboard.name')"
                                    :value="${moduleName}->name ?? ''" :readOnly="true" />

                                <x-backend.dashboard.form.input inputName="canonical" type="text"
                                :labelName="__('dashboard.canonical')"   :value="${moduleName}->canonical ?? ''" :readOnly="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('{routerPath}.index') }}" class="btn btn-success mb-20 ">
                            {{__('form.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-danger mb-20 ">
                            {{__('form.delete')}}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
