<x-backend.dashboard.layout>

    <x-slot:heading>
        <script src="https://cdn.tiny.cloud/1/45tp955r5rsk9zjmoshrh28werz7a8oc0urf8hnf0tnavqre/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    </x-slot:heading>

    @php

        $url = isset($postCatalouge)
            ? route('post.catalouge.update', $postCatalouge->post_catalouge_id)
            : route('post.catalouge.store');

        $title = isset($postCatalouge) ? __('form.addObject', ['attribute' => 'Post Group']) : __('form.editObject', ['attribute' => 'Post Group']);

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
                            <h5>{{__('form.ObjectInfor', ['attribute'=>'Common'])}}</h5>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-row flex flex-col gap-10">
                                            <x-backend.dashboard.form.input inputName="name" type="text"
                                                labelName='name' :must="true" rowLength="12" :value="$postCatalouge->name ?? ''" />

                                            <x-backend.dashboard.form.input inputName="description" type="text"
                                                labelName='description' rowLength="12" :value="$postCatalouge->description ?? ''"
                                                tag='textarea' />


                                            <x-backend.dashboard.form.input inputName="content" type="text"
                                                labelName='content' rowLength="12" :value="$postCatalouge->content ?? ''" tag='textarea' />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <x-backend.dashboard.album :album="$postCatalouge->album ?? '' "/>


                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{__('form.seoSet')}}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="seo-wrapper flex flex-col gap-10">
                                <x-backend.dashboard.form.seo
                                    labelName='title'
                                    inputName='meta_title'
                                    :value="$postCatalouge->meta_title ?? ''"
                                />
                                <x-backend.dashboard.form.seo
                                    labelName='keyword'
                                    inputName='meta_keyword'
                                    :value="$postCatalouge->meta_keyword ?? ''"
                                />
                                <x-backend.dashboard.form.seo
                                    labelName='description'
                                    inputName='meta_description'
                                    tag='textarea'
                                    :value="$postCatalouge->meta_description ?? ''"
                                    />
                                <x-backend.dashboard.form.seo
                                    labelName='link'
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
                                {{__('form.chooseObject', ['attribute' => 'Parent Section'])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.select labelName="Parent Section" name="parent_id"
                                    rowLength="12" :data="$listNode" :value="$postCatalouge->parent_id ?? ''" />
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.chooseObject', ['attribute' => 'Language'])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <x-backend.dashboard.form.select labelName="Language" name="language_id"
                                            rowLength="12" :data="$languages" :must="true" :value="$postCatalouge->language_id ?? ''" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.chooseObject', ['attribute' => 'Post Group Image'])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-backend.dashboard.form.upload rowLength="12" labelName="post group image" :value="$postCatalouge->image ?? '' " />
                                    <img class="col-lg-12 hidden" id="img_show" alt="post group image"
                                        height="250px">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.advanceSet')}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12 flex flex-col gap-10">
                                    <div class="flex gap-10">
                                        <select name="publish" class="form-control  select2">
                                            <option disabled selected>
                                                {{__('form.chooseObject', ['attribute' => 'Post Group Status'])}}
                                            </option>
                                            <option value="1" @selected(old('publish', $publish) == 1)>
                                                {{__('form.published')}}
                                            </option>
                                            <option value="2" @selected(old('publish', $publish) == 2)>
                                                {{__('form.private')}}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="flex gap-10">
                                        <select name="follow" class="form-control  select2">
                                            <option disabled selected> {{__('form.chooseObject', ['attribute' => 'Post Group Direction'])}}</option>
                                            <option value="1" @selected(old('follow', $follow) == 1)>
                                                {{__('form.follow')}}
                                            </option>
                                            <option value="2" @selected(old('follow', $follow) == 2)>
                                                {{__('form.unfollow')}}
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
                    {{__('form.cancel')}}
                </a>
                <button type="submit" class="btn btn-primary mb-20 ">
                    {{__('form.save')}}
                </button>
            </div>
    </form>
</x-backend.dashboard.layout>
