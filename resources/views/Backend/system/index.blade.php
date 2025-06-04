<x-backend.dashboard.layout>

    <x-slot:heading>
        <script src="https://cdn.tiny.cloud/1/45tp955r5rsk9zjmoshrh28werz7a8oc0urf8hnf0tnavqre/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    </x-slot:heading>

    <div class="row wrapper border-bottom white-bg page-heading">
        <x-backend.dashboard.breadcrumb :title="__('custom.attrConfig', ['attribute' => __('custom.system')])" />
    </div>

    <form action="{{ route('system.store') }}" method="POST" class="mt-20">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            @foreach ($data as $dataKey => $dataVal)
                <div class="row">
                    <div class="col-lg-5">
                        <h3 class="panel-title">
                            {{ __($dataVal['title']) }}
                        </h3>
                        <div class="pannel-description">
                            {{ __($dataVal['description']) }}
                        </div>

                    </div>
                    <div class="col-lg-7">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>{{ __($dataVal['title']) }}</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row flex flex-col gap-10">
                                    @foreach ($dataVal['value'] as $key => $val)
                                        @php
                                            $name = $dataKey . '_' . $key;
                                        @endphp

                                        @switch($val['type'])
                                            @case('image')
                                                <x-backend.dashboard.form.upload rowLength="12" :labelName="__($val['label'])"
                                                    :inputName="$name" :value="$systemConfig[$name] ?? ''" />
                                            @break

                                            @case('map')
                                                <div class="col-lg-12">
                                                    <div class="form-row">
                                                        <div class="flex flex-space-between">
                                                            <label for="{{ $name }}"
                                                                class="control-label text-right text-capitalize">
                                                                {{ __($val['label']) }}
                                                            </label>
                                                            <a href="{{ $val['link']['href'] }}"
                                                                target="{{ $val['link']['target'] }}" class="italic text-bold">
                                                                {{ __($val['link']['text']) }}
                                                            </a>
                                                        </div>
                                                        <textarea rows="5" type="textarea" name="{{ $name }}" id="{{ $name }}"
                                                            class="form-control ck-editor">
                                                        {{ old($name, $systemConfig[$name] ?? '') }}
                                                    </textarea>
                                                    </div>
                                                </div>
                                            @break

                                            @case('select')
                                                <div class="col-lg-12">
                                                    <div class="form-row">
                                                        <label class="control-label text-right text-capitalize"
                                                            for="{{ $name }}">
                                                            {{ __($val['label']) }}
                                                        </label>
                                                        <select class="form-control" name="{{ $name }}"
                                                            id="{{ $name }}">
                                                            @foreach ($val['option'] as $optionKey => $optionVal)
                                                                <option value="{{ $optionKey }}">{{ __($optionVal) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @break

                                            @default
                                                <x-backend.dashboard.form.input :inputName="$name" :type="$val['type']"
                                                    :tag="$val['type']" :labelName="__($val['label'])" rowLength="12" :value="$systemConfig[$name] ?? ''" />
                                        @endswitch
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

            <div class="flex flex-end">
                <button type="submit" class="btn btn-primary mb-20 ">
                    {{ __('custom.save') }}
                </button>
            </div>
        </div>
    </form>
</x-backend.dashboard.layout>
