<x-backend.dashboard.layout>

    @php
        $url = isset($user) ? route('user.update', $user->id) : route('user.store');
        $title = isset($user) ? __('custom.editObject', ['attribute' => __('custom.member')]) : __('custom.addObject', ['attribute' => __('custom.member')]);
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

    <form action="{{ $url }}" method="POST" class="box">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('custom.ObjectInfor', ['attribute'=> __('custom.common')])}}
                    </h3>
                    <div class="pannel-description">
                        {{ __('custom.enterMember', ['attribute' => $action]) }}
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
                                    :value="$user->email ?? ''"
                                />

                                <x-backend.dashboard.form.input
                                    inputName="name"
                                    type="text"
                                    :labelName="__('custom.name')"
                                    :must="true"
                                    :value="$user->name ?? ''"
                                />
                            </div>

                            <div class="row mt-20">
                                <x-backend.dashboard.form.input
                                    inputName="birthday"
                                    type="date"
                                    :labelName="__('custom.birthday')"
                                    :value="$user->birthday ?? ''"
                                />

                                <x-backend.dashboard.form.select
                                    :labelName="__('custom.memberGroup')"
                                    name="user_catalouge_id"
                                    :data="$groupMember"
                                    :must="true"
                                    :value="$user->userCatalouge->id ?? ''"
                                />
                            </div>
                            @if (!isset($user))
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
                                    :value="$user->image?? ''"
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
                                    :value="$user->address ?? ''"
                                />
                            </div>

                            <div class="row mt-20">
                                <x-backend.dashboard.form.input
                                    inputName="phone"
                                    type="text"
                                    :labelName="__('custom.phone')"
                                    :value="$user->phone ?? ''"
                                />

                                <x-backend.dashboard.form.input
                                    inputName="description"
                                    type="text"
                                    :labelName="__('custom.description')"
                                    :value="$user->description ?? ''"
                                />
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{route('user.index')}}" class="btn btn-success mb-20 ">{{__('custom.cancel')}}</a>
                        <button type="submit" class="btn btn-primary mb-20 ">{{__('custom.save')}}</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <script>
        var provinceId = '{{ !empty($user->province_id) ? $user->province_id : old('province_id') }}';
        var districtId = '{{ !empty($user->district_id) ? $user->district_id : old('district_id') }}';
        var wardId = '{{ !empty($user->ward_id) ? $user->ward_id : old('ward_id') }}';
    </script>

</x-backend.dashboard.layout>
