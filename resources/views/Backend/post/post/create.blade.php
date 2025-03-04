<x-backend.dashboard.layout>

    <x-slot:heading>
        <script src="https://cdn.tiny.cloud/1/45tp955r5rsk9zjmoshrh28werz7a8oc0urf8hnf0tnavqre/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    </x-slot:heading>

    @php
        $url = isset($post)
            ? route('post.update', $post->post_id)
            : route('post.store');

        $title = isset($post) ? __('form.editObject', ['attribute' => __('dashboard.post')]) : __('form.addObject', ['attribute' => __('dashboard.post')]);

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
                            <h5>
                                {{__('form.ObjectInfor', ['attribute'=> __('form.common')])}}
                            </h5>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-row flex flex-col gap-10">
                                            <x-backend.dashboard.form.input
                                                inputName="name"
                                                type="text"
                                                :labelName="__('dashboard.name')"
                                                :must="true"
                                                rowLength="12"
                                                :value="$post->name ?? ''"
                                            />

                                            <x-backend.dashboard.form.input
                                                inputName="description"
                                                type="text"
                                                :labelName="__('dashboard.description')"
                                                rowLength="12"
                                                :value="$post->description ?? ''"
                                                tag='textarea'
                                            />


                                            <x-backend.dashboard.form.input
                                                inputName="content"
                                                type="text"
                                                :labelName="__('form.content')"
                                                rowLength="12"
                                                :value="$post->content ?? ''"
                                                tag='textarea'
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <x-backend.dashboard.album :album="$post->album ?? '' "/>


                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.seoSet')}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="seo-wrapper flex flex-col gap-10">
                                <x-backend.dashboard.form.seo
                                    :labelName="__('form.title')"
                                    inputName='meta_title'
                                    :value="$post->meta_title ?? ''"
                                />
                                <x-backend.dashboard.form.seo
                                    :labelName="__('form.keyword')"
                                    inputName='meta_keyword'
                                    :value="$post->meta_keyword ?? ''"
                                />
                                <x-backend.dashboard.form.seo
                                    :labelName="__('dashboard.description')"
                                    inputName='meta_description'
                                    tag='textarea'
                                    :value="$post->meta_description ?? ''"
                                    />
                                <x-backend.dashboard.form.seo
                                    :labelName="__('dashboard.canonical')"
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
                            <h5>
                                {{__('form.chooseObject', ['attribute' => __('form.parentSection')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row flex flex-col gap-10">
                                <x-backend.dashboard.form.select
                                    :labelName="__('form.parentSection')"
                                    name="post_catalouge_id"
                                    rowLength="12"
                                    :data="$listNode"
                                    :value="$post->post_catalouge_id ?? ''"
                                />

                                <x-backend.dashboard.form.multiselect
                                    :labelName="__('form.subSection')"
                                    name="catalouge"
                                    rowLength="12"
                                    :data="$listNode"
                                    :value="$post->catalouges ?? []"
                                    :parent="$post->post_catalouge_id ?? ''"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.chooseObject', ['attribute' => __('dashboard.language')])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <x-backend.dashboard.form.select
                                            :labelName="__('dashboard.language')"
                                            name="language_id"
                                            rowLength="12"
                                            :data="$languages"
                                            :must="true"
                                            :value="$post->language_id ?? ''"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{__('form.chooseObject', ['attribute' => 'Post Image'])}}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-backend.dashboard.form.upload
                                        rowLength="12"
                                        :labelName="__('form.postImage')"
                                        :value="$post->image ?? '' "
                                    />
                                    <img
                                        class="col-lg-12 hidden"
                                        id="img_show"
                                        :alt="__('form.postImage')"
                                        height="250px"
                                    >
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
                                                {{__('form.chooseObject', ['attribute' => __('table.postStatus')])}}
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
                                            <option disabled selected>
                                                {{__('form.chooseObject', ['attribute' => __('form.postVision')])}}
                                            </option>
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
                <a href="{{ route('post.index') }}" class="btn btn-success mb-20 ">
                    {{__('form.cancel')}}
                </a>
                <button type="submit" class="btn btn-primary mb-20 ">
                    {{__('form.save')}}
               </button>
            </div>
    </form>
</x-backend.dashboard.layout>
