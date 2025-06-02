<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb
        :title="__('custom.delObject', ['attribute' => __('custom.generate')])"
    />

    <form action="{{ route('generate.destroy', $generate->id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title text-capitalize">
                        {{ __('custom.ObjectInfor', ['attribute' => __('custom.generate')]) }}
                    </h3>
                    <div class="pannel-description">
                        {{ __('custom.DelQuestion', ['attribute' => __('custom.generate')]) }}
                        <span class="text-danger">{{ ' ' . $generate->name }}</span>
                    </div>
                    <div class="pannel-description">
                        {{ __('custom.DelNote') }}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input
                                    inputName="name"
                                    type="text"
                                    :labelName="__('custom.name')"
                                    :value="$generate->name ?? ''"
                                    :disabled="true"
                                    rowLength="12"
                                />
                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('generate.index') }}" class="btn btn-success mb-20 ">
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
