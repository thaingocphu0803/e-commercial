<x-backend.dashboard.layout>

    @php
        $url = isset($user) ? route('user.update', $user->id) : route('user.store');
        $title = isset($user) ? 'Edit Member' : 'Add Member';
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
                    <h3 class="panel-title">Common Information</h3>
                    <div class="pannel-description">Enter user information to create new member</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Common Information</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.user.form.input inputName="email" type="text" labelName='email'
                                    :must="true" :value="$user->email ?? ''" />

                                <x-backend.user.form.input inputName="name" type="text" labelName='fullname'
                                    :must="true" :value="$user->name ?? ''" />
                            </div>

                            <div class="row mt-20">
                                <x-backend.user.form.input inputName="birthday" type="date" labelName='birthday'
                                    :value="$user->birthday ?? ''" />

                                <x-backend.user.form.select labelName="group member" name="user_catalouge_id"
                                    :data="$groupMember" :must="true" :value="$user->user_catalouge_id ?? ''" />
                            </div>
                            @if (!isset($user))
                                <div class="row mt-20">
                                    <x-backend.user.form.input inputName="password" type="password" labelName='password'
                                        :must="true" />

                                    <x-backend.user.form.input inputName="password_confirmation" type="password"
                                        labelName='password confirmed' :must="true" :data />
                                </div>
                            @endif

                            <div class="row mt-20">
                                <x-backend.user.form.input inputName="image" type="text" rowLength='12'
                                    labelName='Avatar' :value="$user->image ?? ''" />
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">Contact Information</h3>
                    <div class="pannel-description">Contact information can be ignored</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Contact Information</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.user.form.select labelName="city" name="province_id" :data="$provinces" />


                                <x-backend.user.form.select labelName="district" name="district_id" />

                            </div>

                            <div class="row mt-20">
                                <x-backend.user.form.select labelName="ward" name="ward_id" />

                                <x-backend.user.form.input labelName="address" inputName="address" type="text"
                                    :value="$user->address ?? ''" />
                            </div>

                            <div class="row mt-20">
                                <x-backend.user.form.input inputName="phone" type="text" labelName='phone'
                                    :value="$user->phone ?? ''" />

                                <x-backend.user.form.input inputName="description" type="text"
                                    labelName='description' :value="$user->description ?? ''" />
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{route('user.index')}}" class="btn btn-success mb-20 ">Cancel</a>
                        <button type="submit" class="btn btn-primary mb-20 ">Save</button>
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
