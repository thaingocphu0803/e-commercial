<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb
        :title="__('form.delObject', ['attribute' => __('dashboard.language')])"
    />

    <form action="{{ route('language.destroy', $language->id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title text-capitalize">
                        {{ __('form.ObjectInfor', ['attribute' => __('dashboard.language')]) }}
                    </h3>
                    <div class="pannel-description">
                        {{ __('form.DelQuestion', ['attribute' => __('dashboard.language')]) }}
                        <span class="text-danger">{{ ' ' . $language->name }}</span>
                    </div>
                    <div class="pannel-description">
                        {{ __('form.DelNote') }}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="name" type="text" :labelName="__('dashboard.name')"
                                    :value="$language->name ?? ''" :disabled="true" />

                                <x-backend.dashboard.form.input inputName="canonical" type="text" :labelName="__('dashboard.canonical')"
                                    :value="$language->canonical ?? ''" :disabled="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('language.index') }}" class="btn btn-success mb-20 ">
                            {{ __('form.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-danger mb-20 ">
                            {{ __('form.delete') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
