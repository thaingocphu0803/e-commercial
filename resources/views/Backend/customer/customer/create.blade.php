<x-backend.dashboard.layout>

    @php
        $url = isset($customer) ? route('customer.update', $customer->id) : route('customer.store');
        $title = isset($customer) ? __('custom.editObject', ['attribute' => __('custom.customer')]) : __('custom.addObject', ['attribute' => __('custom.customer')]);
        $action = isset($userCatalouge) ? __('custom.edit') : __('custom.create');
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
<div class="row">
    <form action="{{ $url }}" method="POST" class="box">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('custom.ObjectInfor', ['attribute'=> __('custom.common')])}}
                    </h3>
                    <div class="pannel-description">
                        {{ __('custom.enterCustomer', ['attribute' => $action]) }}
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
                                <x-backend.dashboard.form.input
                                    inputName="email"
                                    type="text"
                                    :labelName="__('custom.email')"
                                    :must="true"
                                    :value="$customer->email ?? ''"
                                />

                                <x-backend.dashboard.form.input
                                    inputName="name"
                                    type="text"
                                    :labelName="__('custom.name')"
                                    :must="true"
                                    :value="$customer->name ?? ''"
                                />
                            </div>

                            <div class="row mt-20">
                                <x-backend.dashboard.form.input
                                    inputName="birthday"
                                    type="date"
                                    :labelName="__('custom.birthday')"
                                    :value="$customer->birthday ?? ''"
                                />
                                <x-backend.dashboard.form.select
                                    :labelName="__('custom.gender')"
                                    name="gender"
                                    :data="__('module.customer_type.gender')"
                                    :must="true"
                                    :value="$customer->gender ?? ''"
                                />
                            </div>
                            <div class="row mt-20">
                                <x-backend.dashboard.form.select
                                    :labelName="__('custom.customerCatalouge')"
                                    name="customer_catalouge_id"
                                    :data="$customerCatalouges"
                                    :must="true"
                                    :value="$customer->customerCatalouge->id ?? ''"
                                />

                                <x-backend.dashboard.form.select
                                    :labelName="__('custom.source')"
                                    name="source_id"
                                    :data="$sources"
                                    :must="true"
                                    :value="$customer->source->id ?? ''"
                                />
                            </div>
                            @if (!isset($customer))
                                <div class="row mt-20">
                                    <x-backend.dashboard.form.input
                                        inputName="password"
                                        type="password"
                                        :labelName="__('custom.password')"
                                        :must="true"
                                    />

                                    <x-backend.dashboard.form.input
                                        inputName="password_confirmation"
                                        type="password"
                                        :labelName="__('custom.passwordConfirm')"
                                        :must="true"
                                        :data
                                    />
                                </div>
                            @endif

                            <div class="row mt-20">
                                <x-backend.dashboard.form.upload
                                    rowLength='12'
                                    :labelName="__('custom.avatar')"
                                    :value="$customer->image?? ''"
                                />
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('custom.ObjectInfor', ['attribute'=> __('custom.contacts')] )}}
                    </h3>
                    <div class="pannel-description">
                        {{__('custom.contactInforIgnore')}}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('custom.ObjectInfor', ['attribute'=>__('custom.contacts')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.select
                                    :labelName="__('custom.city')"
                                    name="province_id"
                                    :data="$provinces"
                                />


                                <x-backend.dashboard.form.select
                                    :labelName="__('custom.district')"
                                    name="district_id"
                                />

                            </div>

                            <div class="row mt-20">
                                <x-backend.dashboard.form.select
                                    :labelName="__('custom.ward')"
                                    name="ward_id"
                                />

                                <x-backend.dashboard.form.input
                                    :labelName="__('custom.address')"
                                    inputName="address"
                                    type="text"
                                    :value="$customer->address ?? ''"
                                />
                            </div>

                            <div class="row mt-20">
                                <x-backend.dashboard.form.input
                                    inputName="phone"
                                    type="text"
                                    :labelName="__('custom.phone')"
                                    :value="$customer->phone ?? ''"
                                />

                                <x-backend.dashboard.form.input
                                    inputName="description"
                                    type="text"
                                    :labelName="__('custom.description')"
                                    :value="$customer->description ?? ''"
                                />
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{route('customer.index')}}" class="btn btn-success mb-20 ">{{__('custom.cancel')}}</a>
                        <button type="submit" class="btn btn-primary mb-20 ">{{__('custom.save')}}</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
    <script>
        var provinceId = '{{ !empty($customer->province_id) ? $customer->province_id : old('province_id') }}';
        var districtId = '{{ !empty($customer->district_id) ? $customer->district_id : old('district_id') }}';
        var wardId = '{{ !empty($customer->ward_id) ? $customer->ward_id : old('ward_id') }}';
    </script>

</x-backend.dashboard.layout>
