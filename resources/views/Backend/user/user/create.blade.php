<x-backend.dashboard.layout>

    @php
        $url = isset($user) ? route('user.update', $user->id) : route('user.store');
        $title = isset($user) ? __('form.addObject', ['attribute' => 'Member']) : __('form.editObject', ['attribute' => 'Member']);
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
                        {{__('form.ObjectInfor', ['attribute'=>'Common'])}}
                    </h3>
                    <div class="pannel-description">
                        {{ __('form.enterMember', 'attribute' =>(isset($user) ? 'edit' : 'create new')) }}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.ObjectInfor', ['attribute'=>'Common'])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="email" type="text" labelName='email'
                                    :must="true" :value="$user->email ?? ''" />

                                <x-backend.dashboard.form.input inputName="name" type="text" labelName='fullname'
                                    :must="true" :value="$user->name ?? ''" />
                            </div>

                            <div class="row mt-20">
                                <x-backend.dashboard.form.input inputName="birthday" type="date" labelName='birthday'
                                    :value="$user->birthday ?? ''" />

                                <x-backend.dashboard.form.select labelName="member group" name="user_catalouge_id"
                                    :data="$groupMember" :must="true" :value="$user->userCatalouge->id ?? ''" />
                            </div>
                            @if (!isset($user))
                                <div class="row mt-20">
                                    <x-backend.dashboard.form.input inputName="password" type="password" labelName='password'
                                        :must="true" />

                                    <x-backend.dashboard.form.input inputName="password_confirmation" type="password"
                                        labelName='password confirmed' :must="true" :data />
                                </div>
                            @endif

                            <div class="row mt-20">
                                <x-backend.dashboard.form.upload rowLength='12' labelName='Avatar' :value="$user->image?? ''"/>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('form.ObjectInfor', ['attribute'=>'Contact'] )}}
                    </h3>
                    <div class="pannel-description">
                        {{__('form.contactInforIgnore')}}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.ObjectInfor') ['attribute'=>'Contact']}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.select labelName="city" name="province_id" :data="$provinces" />


                                <x-backend.dashboard.form.select labelName="district" name="district_id" />

                            </div>

                            <div class="row mt-20">
                                <x-backend.dashboard.form.select labelName="ward" name="ward_id" />

                                <x-backend.dashboard.form.input labelName="address" inputName="address" type="text"
                                    :value="$user->address ?? ''" />
                            </div>

                            <div class="row mt-20">
                                <x-backend.dashboard.form.input inputName="phone" type="text" labelName='phone'
                                    :value="$user->phone ?? ''" />

                                <x-backend.dashboard.form.input inputName="description" type="text"
                                    labelName='description' :value="$user->description ?? ''" />
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{route('user.index')}}" class="btn btn-success mb-20 ">{{__('form.cancel')}}</a>
                        <button type="submit" class="btn btn-primary mb-20 ">{{__('form.save')}}</button>
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
