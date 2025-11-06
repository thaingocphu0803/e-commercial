<x-backend.dashboard.layout>

    @php
        $url = isset($source)
            ? route('source.update', $source->id)
            : route('source.store');

        $title = isset($source) ? __('custom.editObject', ['attribute' => __('custom.source')]) : __('custom.addObject', ['attribute' => __('custom.source')]);

        $publish = $source->publish ?? '';
        $follow = $source->follow ?? '';
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

    <form action="{{ $url }}" method="POST" class="box" id="source_form">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-9">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('custom.ObjectInfor', ['attribute'=> __('custom.common')])}}
                            </h5>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-row flex flex-col gap-10">
                                            <x-backend.dashboard.form.input
                                                inputName="description"
                                                type="text"
                                                :labelName="__('custom.description')"
                                                rowLength="12"
                                                :value="$source->description ?? ''"
                                                tag='textarea'
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('custom.ObjectInfor', ['attribute' => __('custom.basic')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row flex flex-col gap-10">
                                <x-backend.dashboard.form.input
                                    inputName="name"
                                    type="text"
                                    :labelName="__('custom.name')"
                                    :must="true"
                                    rowLength="12"
                                    :value="$source->name ?? ''"
                                />
                                <x-backend.dashboard.form.input
                                    inputName="keyword"
                                    type="text"
                                    :labelName="__('custom.keyword')"
                                    :must="true"
                                    rowLength="12"
                                    :value="$source->keyword ?? ''"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-space-between">
                <a href="{{ route('source.index') }}" class="btn btn-success mb-20 ">
                    {{__('custom.cancel')}}
                </a>
                <button type="submit" class="btn btn-primary mb-20 ">
                    {{__('custom.save')}}
               </button>
            </div>
    </form>
</div>
</x-backend.dashboard.layout>
