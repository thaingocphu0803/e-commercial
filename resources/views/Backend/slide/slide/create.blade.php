<x-backend.dashboard.layout>

    @php
        $url = isset($slide) ? route('slide.update', $slide->id) : route('slide.store');
        $title = isset($slide)
            ? __('custom.editObject', ['attribute' => __('custom.slide')])
            : __('custom.addObject', ['attribute' => __('custom.slide')]);
        $action = isset($slide) ? __('custom.edit') : __('custom.create');

        $item =  isset($slide) ? json_decode($slide['item'], true) : [];
        $settings = isset($slide) ?  json_decode($slide['settings']) : [];

        $arrow =  $settings->arrow ?? null;
        $autoplay =  $settings->autoplay ?? null;
        $pauseHover =  $settings->pauseHover ?? null;
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
                    <div class="col-lg-8">
                        <div class="ibox">
                            <div class="ibox-title flex flex-space-between flex-middle">
                                <h5>
                                    {{ __('custom.listSlide') }}
                                </h5>
                                <button type="button" class="btn btn-success addSlide">
                                    {{ __('custom.addSlide') }}
                                </button>
                            </div>
                            <div id="sortable" class="ibox-content slide-list sortui ui-sortable">
                                @php
                                    $slides = old('slides', $item) ?? [];
                                @endphp
                                @if (count($slides))
                                    @foreach ($slides['image'] as $key => $val)
                                    @php
                                        $image = $slides['image'][$key];
                                        $id = $slides['id'][$key];
                                        $desc = $slides['desc'][$key];
                                        $url = $slides['url'][$key];
                                        $newtab = $slides['newtab'][$key] ?? null;
                                        $name = $slides['name'][$key];
                                        $alt = $slides['alt'][$key];
                                    @endphp
                                        <div class="row ui-state-default">
                                            <div class="col-lg-3 relative">
                                                <img src="{{$image}}" alt="" class="img-cover li">
                                                <input type="hidden" name="slides[image][]" value="{{$image}}">
                                                <input type="hidden" name="slides[id][]" value="{{$id}}">
                                                <button class="btn btn-danger deleteSlide" type="button">
                                                    <i class="fa fa-trash fa-lg"></i>
                                                </button>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="tabs-container">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a data-toggle="tab" href="#tab-1-{{$id}}"
                                                                aria-expanded="true">
                                                                {{__('custom.commonInf')}}
                                                            </a>
                                                        </li>
                                                        <li class=""><a data-toggle="tab" href="#tab-2-{{$id}}"
                                                                aria-expanded="false">SEO</a>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content">
                                                        <div id="tab-1-{{$id}}" class="tab-pane active">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-row">
                                                                            <label for="slide-desc-{{$id}}"
                                                                                class="control-label text-right text-capitalize">
                                                                                {{__('custom.description')}}
                                                                            </label>
                                                                            <textarea class="form-control tiny-editor" type="text" rows="3" name="slides[desc][]" id="slide-desc-{{$id}}">
                                                                                {{ $desc}}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="row mt-10 flex flex-space-between flex-middle">
                                                                    <div class="col-lg-9">
                                                                        <input type="text" class="form-control"
                                                                            name="slides[url][]" placeholder="URL" value="{{$url}}">
                                                                    </div>
                                                                    <div
                                                                        class="col-lg-3 flex flex-end gap-10 flex-middle">
                                                                        <input type="checkbox" class="m-0"
                                                                            name="slides[newtab][]" value="_blank"
                                                                            id="slide_newtab" {{$newtab ? 'checked' : ''}}>
                                                                        <label for="slide_newtab"
                                                                            class="m-0 text-500 text-sm">
                                                                            {{__('custom.opNewTab')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="tab-2-{{$id}}" class="tab-pane">
                                                            <div class="panel-body">
                                                                <div class="col-lg-12">
                                                                    <div class="form-row">
                                                                        <label for="slide-name-{{$id}}"
                                                                            class="control-label text-right text-capitalize">
                                                                            {{__('custom.iTitle')}}
                                                                        </label>
                                                                        <input class="form-control" type="text"
                                                                            name="slides[name][]" id="slide-name-{{$id}}" value="{{$name}}">
                                                                        </input>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12 mt-5">
                                                                    <div class="form-row">
                                                                        <label for="slide-alt-{{$id}}"
                                                                            class="control-label text-right text-capitalize">
                                                                             {{__('custom.iDesc')}}
                                                                        </label>
                                                                        <input class="form-control" type="text"
                                                                            name="slides[alt][]" id="slide-alt-{{$id}}" value="{{$alt}}">
                                                                        </input>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ibox slide-basic-config">
                            <div class="ibox-title">
                                <h5>
                                    {{ __('custom.basicConfig') }}
                                </h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row flex flex-col gap-10">
                                    <x-backend.dashboard.form.input inputName="name" type="text" :labelName="__('custom.name')"
                                        :must="true" :value="$slide->name ?? ''" :rowLength="12" />
                                    <x-backend.dashboard.form.input inputName="keyword" type="text" :labelName="__('custom.keyword')"
                                        :must="true" :value="$slide->keyword ?? ''" :rowLength="12" />

                                    <div class="dimentions">
                                        <x-backend.dashboard.form.input inputName="settings[width]" type="text"
                                            :labelName="__('custom.width') . ' (px)'" :value="$settings->width ?? 0" inputArrName="settings.width"/>
                                        <x-backend.dashboard.form.input inputName="settings[height]" type="text"
                                            :labelName="__('custom.height') . ' (px)'" :value="$settings->height ?? 0" inputArrName="settings.height"/>
                                    </div>

                                    <div class="col-lg-12">
                                        <label for="settings_effect"
                                            class="control-label text-right text-capitalize">{{ __('custom.effect') }}</label>
                                        <select name="settings[effect]" class="form-control select2"
                                            id="settings_effect">
                                            @foreach (__('module.effect') as $key => $value)
                                                <option value="{{ $key }}" {{old('settings.effect', $settings->effect ?? null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <x-backend.dashboard.form.checkbox :labelName="__('custom.arrow')" value="accept"
                                        name="settings[arrow]" rowLength="12" :checked="(!old() && empty($arrow))|| old('settings.arrow', $arrow) == 'accept' ? 'checked' : '' ">
                                    </x-backend.dashboard.form.checkbox>

                                    <div class="col-lg-12">
                                        <label for="hiddenDirection">{{ __('custom.navigate') }}</label>
                                        <div class='row flex flex-col gap-10'>
                                            @foreach (__('module.navigate') as $key => $val)
                                                <x-backend.dashboard.form.radio :labelName="$val" :value="$key ?? ''"
                                                    name="settings[navigate]" rowLength="12" :old="old('settings.navigate', $settings->navigate ?? null) ?? 'dots' ">
                                                </x-backend.dashboard.form.radio>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="ibox slide-advance-config">
                            <div class="ibox-title">
                                <h5>
                                    {{ __('custom.advanceConfig') }}
                                </h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row flex flex-col gap-10">
                                    <x-backend.dashboard.form.checkbox :labelName="__('custom.autoPlay')" value="accept"
                                        name="settings[autoplay]" rowLength="12" :checked="(!old() && empty($autoplay)) || old('settings.autoplay', $autoplay) == 'accept' ? 'checked' : ''">
                                    </x-backend.dashboard.form.checkbox>
                                    <x-backend.dashboard.form.checkbox :labelName="__('custom.hoverPause')" value="accept"
                                        name="settings[pauseHover]" rowLength="12" :checked="(!old() && empty($pauseHover)) || old('settings.pauseHover', $pauseHover) == 'accept' ? 'checked' : ''">
                                    </x-backend.dashboard.form.checkbox>
                                </div>
                                <div class="row mt-10">
                                    <x-backend.dashboard.form.input inputName="settings[duration_slide]"
                                        type="text" :labelName="__('custom.durationSlide') . ' (s)'" :value="$settings->duration_slide ?? null"  inputArrName="settings.duration_slide"/>
                                    <x-backend.dashboard.form.input inputName="settings[speed_effect]" type="text"
                                        :labelName="__('custom.speedEffect') . ' (ms)'" :value="$settings->speed_effect ?? null" inputArrName="settings.speed_effect"/>
                                </div>
                            </div>

                        </div>
                        <div class="ibox slide-shortcode">
                            <div class="ibox-title">
                                <h5>
                                    {{ __('custom.shortcode') }}
                                </h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <x-backend.dashboard.form.input inputName="short_code" type="text"
                                        tag="textarea" :labelName="__('custom.shortcode')" :value="$slide->short_code ?? null" rowLength="12"
                                        rows="10"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-space-between">
                    <a href="{{ route('slide.index') }}"
                        class="btn btn-success mb-20 ">{{ __('custom.cancel') }}</a>
                    <button type="submit" class="btn btn-primary mb-20 ">{{ __('custom.save') }}</button>
                </div>
            </div>
        </form>
    </div>

</x-backend.dashboard.layout>
