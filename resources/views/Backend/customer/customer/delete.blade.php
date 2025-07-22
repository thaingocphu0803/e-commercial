<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb
        :title="__('custom.delObject', ['attribute'=>__('custom.customer')])"
    />

    <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('custom.ObjectInfor', ['attribute' => __('custom.customer')])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('custom.DelQuestion', ['attribute' => __('custom.customer')])}}
                        <span class="text-danger">{{ $customer->name }}</span>
                    </div>
                    <div class="pannel-description">{{__('custom.DelNote')}}</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="email" type="text" :labelName="__('custom.name')"
                                    :value="$customer->email ?? ''" :disabled="true" />

                                <x-backend.dashboard.form.input inputName="name" type="text" :labelName="__('custom.fullname')"
                                    :value="$customer->name ?? ''" :disabled="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('customer.index') }}" class="btn btn-success mb-20 ">
                            {{__('custom.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-danger mb-20 ">
                            {{__('custom.delete')}}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <script>
        var provinceId = '{{ !empty($customer->province_id) ? $customer->province_id : old('province_id') }}';
        var districtId = '{{ !empty($customer->district_id) ? $customer->district_id : old('district_id') }}';
        var wardId = '{{ !empty($customer->ward_id) ? $customer->ward_id : old('ward_id') }}';
    </script>

</x-backend.dashboard.layout>
