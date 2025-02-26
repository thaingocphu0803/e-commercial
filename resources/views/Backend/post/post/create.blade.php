<x-backend.dashboard.layout>

    <x-slot:heading>
        <script src="https://cdn.tiny.cloud/1/45tp955r5rsk9zjmoshrh28werz7a8oc0urf8hnf0tnavqre/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    </x-slot:heading>

    @php

        $url = isset($post)
            ? route('post.update', $post->post_catalouge_id)
            : route('post.store');

        $title = isset($post) ? 'Edit Post' : 'Add Post';

        $publish = $post->publish ?? '';
        $follow = $post->follow ?? '';
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
                            <h5>Common Information</h5>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-row flex flex-col gap-10">
                                            <x-backend.dashboard.form.input inputName="name" type="text"
                                                labelName='name' :must="true" rowLength="12" :value="$post->name ?? ''" />

                                            <x-backend.dashboard.form.input inputName="description" type="text"
                                                labelName='description' rowLength="12" :value="$post->description ?? ''"
                                                tag='textarea' />


                                            <x-backend.dashboard.form.input inputName="content" type="text"
                                                labelName='content' rowLength="12" :value="$post->content ?? ''" tag='textarea' />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <x-backend.dashboard.album :album="$post->album ?? '' "/>


                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>SEO setting</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="seo-wrapper flex flex-col gap-10">
                                <x-backend.dashboard.form.seo
                                    labelName='title'
                                    inputName='meta_title'
                                    :value="$post->meta_title ?? ''"
                                />
                                <x-backend.dashboard.form.seo
                                    labelName='keyword'
                                    inputName='meta_keyword'
                                    :value="$post->meta_keyword ?? ''"
                                />
                                <x-backend.dashboard.form.seo
                                    labelName='description'
                                    inputName='meta_description'
                                    tag='textarea'
                                    :value="$post->meta_description ?? ''"
                                    />
                                <x-backend.dashboard.form.seo
                                    labelName='link'
                                    inputName='canonical'
                                    :must="true"
                                    :value="$post->canonical ?? ''"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>CHOOSE PARENT SECTION</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row flex flex-col gap-10">
                                <x-backend.dashboard.form.select labelName="Parent Section" name="post_catalouge_id"
                                    rowLength="12" :data="$listNode" :value="$post->parent_id ?? ''" />

                                    <x-backend.dashboard.form.multiselect labelName="Sub Section" name="catalouge"
                                    rowLength="12" :data="$listNode" :value="$post->parent_id ?? ''" />
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>CHOOSE LANGUAGE</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <x-backend.dashboard.form.select labelName="Language" name="language_id"
                                            rowLength="12" :data="$languages" :must="true" :value="$post->language_id ?? ''" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>CHOOSE POST IMAGE</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-backend.dashboard.form.upload rowLength="12" labelName="post image" :value="$post->image ?? '' " />
                                    <img class="col-lg-12 hidden" id="img_show" alt="post image"
                                        height="250px">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>ADVANCE SETTING</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12 flex flex-col gap-10">
                                    <div class="flex gap-10">
                                        <select name="publish" class="form-control  select2">
                                            <option disabled selected> Choose Post Status</option>
                                            <option value="1" @selected(old('publish', $publish) == 1)>Published</option>
                                            <option value="2" @selected(old('publish', $publish) == 2)>Private</option>
                                        </select>
                                    </div>

                                    <div class="flex gap-10">
                                        <select name="follow" class="form-control  select2">
                                            <option disabled selected> Choose Post Direction</option>
                                            <option value="1" @selected(old('follow', $follow) == 1)>Follow</option>
                                            <option value="2" @selected(old('follow', $follow) == 2)>Unfollow</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-space-between">
                <a href="{{ route('post.index') }}" class="btn btn-success mb-20 ">Cancel</a>
                <button type="submit" class="btn btn-primary mb-20 ">Save</button>
            </div>
    </form>
</x-backend.dashboard.layout>
