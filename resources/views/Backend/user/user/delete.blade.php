<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb
        :title="__('form.delObject', ['attribute'=>__('dashboard.member')])"
    />

    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('form.ObjectInfor', ['attribute' => __('dashboard.member')])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('form.DelQuestion', ['attribute' => __('dashboard.member')])}}
                        <span class="text-danger">{{ $user->name }}</span>
                    </div>
                    <div class="pannel-description">{{__('form.DelNote')}}</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="email" type="text" :labelName="__('table.name')"
                                    :value="$user->email ?? ''" :disabled="true" />

                                <x-backend.dashboard.form.input inputName="name" type="text" :labelName="__('table.fullname')"
                                    :value="$user->name ?? ''" :disabled="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('user.index') }}" class="btn btn-success mb-20 ">
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

    <script>
        var provinceId = '{{ !empty($user->province_id) ? $user->province_id : old('province_id') }}';
        var districtId = '{{ !empty($user->district_id) ? $user->district_id : old('district_id') }}';
        var wardId = '{{ !empty($user->ward_id) ? $user->ward_id : old('ward_id') }}';
    </script>

</x-backend.dashboard.layout>
