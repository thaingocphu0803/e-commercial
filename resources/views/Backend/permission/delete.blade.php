<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb
        :title="__('custom.delObject', ['attribute' => __('custom.permission')])"
    />

    <form action="{{ route('permission.destroy', $permission->id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title text-capitalize">
                        {{ __('custom.ObjectInfor', ['attribute' => __('custom.permission')]) }}
                    </h3>
                    <div class="pannel-description">
                        {{ __('custom.DelQuestion', ['attribute' => __('custom.permission')]) }}
                        <span class="text-danger">{{ ' ' . $permission->name }}</span>
                    </div>
                    <div class="pannel-description">
                        {{ __('custom.DelNote') }}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="name" type="text" :labelName="__('custom.name')"
                                    :value="$permission->name ?? ''" :disabled="true" />

                                <x-backend.dashboard.form.input inputName="canonical" type="text" :labelName="__('custom.canonical')"
                                    :value="$permission->canonical ?? ''" :disabled="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('permission.index') }}" class="btn btn-success mb-20 ">
                            {{ __('custom.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-danger mb-20 ">
                            {{ __('custom.delete') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
