<x-backend.dashboard.layout>

    <x-slot:heading>
        <script src="https://cdn.tiny.cloud/1/45tp955r5rsk9zjmoshrh28werz7a8oc0urf8hnf0tnavqre/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    </x-slot:heading>

    @php

        $url = isset($postCatalouge)
            ? route('post.catalouge.update', $postCatalouge->post_catalouge_id)
            : route('post.catalouge.store');

        $title = isset($postCatalouge) ? __('custom.editObject', ['attribute' => __('custom.postGroup')]) : __('custom.addObject', ['attribute' => __('custom.postGroup')]);

        $publish = $postCatalouge->publish ?? '';
        $follow = $postCatalouge->follow ?? '';
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



    <form action="{{ $url }}" method="POST" class="box" id="post_catalouge_form">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-9">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{__('custom.ObjectInfor', ['attribute'=> __('custom.common')])}}</h5>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-row flex flex-col gap-10">
                                            <x-backend.dashboard.form.input
                                                inputName="name"
                                                type="text"
                                                :labelName="__('custom.name')"
                                                :must="true" rowLength="12"
                                                :value="$postCatalouge->name ?? ''"
                                            />

                                            <x-backend.dashboard.form.input
                                                inputName="description"
                                                type="text"
                                                :labelName="__('custom.description')"
                                                rowLength="12"
                                                :value="$postCatalouge->description ?? ''"
                                                tag='textarea'
                                            />


                                            <x-backend.dashboard.form.input
                                                inputName="content"
                                                type="text"
                                                :labelName="__('custom.content')"
                                                rowLength="12"
                                                :value="$postCatalouge->content ?? ''"
                                                tag='textarea'
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <x-backend.dashboard.album :album="$postCatalouge->album ?? '' "/>


                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{__('custom.seoSet')}}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="seo-wrapper flex flex-col gap-10">
                                <x-backend.dashboard.form.seo
                                    :labelName="__('custom.title')"
                                    inputName='meta_title'
                                    :value="$postCatalouge->meta_title ?? ''"
                                />
                                <x-backend.dashboard.form.seo
                                    :labelName="__('custom.keyword')"
                                    inputName='meta_keyword'
                                    :value="$postCatalouge->meta_keyword ?? ''"
                                />
                                <x-backend.dashboard.form.seo
                                    :labelName="__('custom.description')"
                                    inputName='meta_description'
                                    tag='textarea'
                                    :value="$postCatalouge->meta_description ?? ''"
                                    />
                                <x-backend.dashboard.form.seo
                                    :labelName="__('custom.canonical')"
                                    inputName='canonical'
                                    :must="true"
                                    :value="$postCatalouge->canonical ?? ''"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('custom.chooseObject', ['attribute' => __('custom.parentSection')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.select
                                    :labelName="__('custom.parentSection')"
                                    name="parent_id"
                                    rowLength="12"
                                    :data="$listNode"
                                    :value="$postCatalouge->parent_id ?? ''"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('custom.chooseObject', ['attribute' => __('custom.language')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <x-backend.dashboard.form.select
                                            :labelName="__('custom.language')"
                                            name="language_id"
                                            rowLength="12"
                                            :data="$languages"
                                            :must="true"
                                            :value="$postCatalouge->language_id ?? ''"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('custom.chooseObject', ['attribute' => __('custom.postGroupImage')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-backend.dashboard.form.upload
                                        rowLength="12"
                                        :labelName="__('custom.postGroupImage')"
                                        :value="$postCatalouge->image ?? '' "
                                    />
                                    <img
                                        class="col-lg-12 hidden"
                                        id="img_show"
                                        :alt="__('custom.postGroupImage')"
                                        height="250px"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('custom.advanceSet')}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12 flex flex-col gap-10">
                                    <div class="flex gap-10">
                                        <select name="publish" class="form-control  select2">
                                            <option disabled selected>
                                                {{__('custom.chooseObject', ['attribute' => __('custom.postGroupStatus')])}}
                                            </option>
                                            <option value="1" @selected(old('publish', $publish) == 1)>
                                                {{__('custom.published')}}
                                            </option>
                                            <option value="2" @selected(old('publish', $publish) == 2)>
                                                {{__('custom.private')}}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="flex gap-10">
                                        <select name="follow" class="form-control  select2">
                                            <option disabled selected>
                                                 {{__('custom.chooseObject', ['attribute' => __('custom.postGroupVision')])}}
                                            </option>
                                            <option value="1" @selected(old('follow', $follow) == 1)>
                                                {{__('custom.follow')}}
                                            </option>
                                            <option value="2" @selected(old('follow', $follow) == 2)>
                                                {{__('custom.unfollow')}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-space-between">
                <a href="{{ route('post.catalouge.index') }}" class="btn btn-success mb-20 ">
                    {{__('custom.cancel')}}
                </a>
                <button type="submit" class="btn btn-primary mb-20 ">
                    {{__('custom.save')}}
                </button>
            </div>
    </form>
</x-backend.dashboard.layout>
