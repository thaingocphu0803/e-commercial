<x-backend.dashboard.layout>

    @php
        $url = isset($userCatalouge) ? route('user.catalouge.update', $userCatalouge->id) : route('user.catalouge.store');
        $title = isset($userCatalouge) ? __('form.editObject', ['attribute' => __('dashboard.memberGroup')]) : __('form.addObject', ['attribute' => __('dashboard.memberGroup')]);
        $action = isset($userCatalouge) ? __('form.edit') : __('form.create');
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
                        {{__('form.ObjectInfor', ['attribute'=> __('form.common')])}}
                    </h3>
                    <div class="pannel-description">
                        {{ __('form.enterMemberGroup', ['attribute' => $action])}}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.ObjectInfor', ['attribute'=> __('form.common')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input
                                    inputName="name"
                                    type="text"
                                    :labelName="__('dashboard.name')"
                                    :must="true"
                                    :value="$userCatalouge->name ?? ''"
                                />

                                <x-backend.dashboard.form.input
                                    inputName="description"
                                    type="text"
                                    :labelName="__('dashboard.description')"
                                    :value="$userCatalouge->description ?? ''"
                                />
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{route('user.catalouge.index')}}" class="btn btn-success mb-20 ">
                            {{__('form.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-primary mb-20 ">
                            {{__('form.save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
