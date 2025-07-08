<x-backend.dashboard.layout>

    @php
        $url = isset($userCatalouge) ? route('user.catalouge.update', $userCatalouge->id) : route('user.catalouge.store');
        $title = isset($userCatalouge) ? __('custom.editObject', ['attribute' => __('custom.memberGroup')]) : __('custom.addObject', ['attribute' => __('custom.memberGroup')]);
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
                        {{ __('custom.enterMemberGroup', ['attribute' => $action])}}
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
                                    inputName="name"
                                    type="text"
                                    :labelName="__('custom.name')"
                                    :must="true"
                                    :value="$userCatalouge->name ?? ''"
                                />

                                <x-backend.dashboard.form.input
                                    inputName="description"
                                    type="text"
                                    :labelName="__('custom.description')"
                                    :value="$userCatalouge->description ?? ''"
                                />
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{route('user.catalouge.index')}}" class="btn btn-success mb-20 ">
                            {{__('custom.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-primary mb-20 ">
                            {{__('custom.save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</x-backend.dashboard.layout>
