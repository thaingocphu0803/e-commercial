<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb
        :title="__('custom.delObject', ['attribute'=>__('custom.customerCatalouge')])"
    />

    <form action="{{ route('customer.catalouge.destroy', $customerCatalouge->id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('custom.ObjectInfor', ['attribute' =>__('custom.customerCatalouge')])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('custom.DelQuestion', ['attribute' => __('custom.customerCatalouge')])}}
                        <span class="text-danger">{{ $customerCatalouge->name }}</span>
                    </div>
                    <div class="pannel-description">
                        {{__('custom.DelNote')}}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="name" type="text" labelName='name'
                                    :value="$customerCatalouge->name ?? ''" :disabled="true" />

                                <x-backend.dashboard.form.input inputName="description" type="text" labelName='description'
                                    :value="$customerCatalouge->description ?? ''" :disabled="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('customer.catalouge.index') }}" class="btn btn-success mb-20 ">
                            {{__('custom.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-danger mb-20 ">
                            {{__('custom.save')}}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
