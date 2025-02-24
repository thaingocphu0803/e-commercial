<x-backend.dashboard.layout>

    <x-slot:heading>
        <script src="https://cdn.tiny.cloud/1/45tp955r5rsk9zjmoshrh28werz7a8oc0urf8hnf0tnavqre/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    </x-slot:heading>

    @php
        $url = isset($postCatalouge)
            ? route('post.catalouge.update', $postCatalouge->id)
            : route('post.catalouge.store');
        $title = isset($postCatalouge) ? 'Edit Post Group' : 'Add Post Group';
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
                <div class="col-lg-9">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Common Information</h5>
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

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>SEO setting</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="seo-wrapper flex flex-col gap-10">
                                <x-backend.dashboard.form.seo labelName='title' inputName='meta_title' />
                                <x-backend.dashboard.form.seo labelName='keyword' inputName='meta_keyword' />
                                <x-backend.dashboard.form.seo labelName='description' inputName='meta_description'
                                    tag='textarea' />
                                <x-backend.dashboard.form.seo labelName='link' inputName='canonical'
                                    :must="true" />
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
                            <div class="row">
                                <x-backend.dashboard.form.select labelName="Parent Section" name="parent_id"
                                    rowLength="12" :data="$listNode" {{-- :value="$user->userCatalouge->id ?? ''" --}} />
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
                                            rowLength="12" :data="$languages" :must="true" {{-- :value="$user->userCatalouge->id ?? ''" --}} />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>CHOOSE POST GROUP IMAGE</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-backend.dashboard.form.upload rowLength="12" labelName="post group image" />
                                    <img class="col-lg-12 hidden" id="img_show" src="" alt="post group image"
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
                                            <option disabled selected> Choose Post Group Status</option>
                                            <option value="1" @selected(old('publish') == 1)>Published</option>
                                            <option value="2" @selected(old('publish') == 2)>Private</option>
                                        </select>
                                    </div>

                                    <div class="flex gap-10">
                                        <select name="follow" class="form-control  select2">
                                            <option disabled selected> Choose Post Group Direction</option>
                                            <option value="1" @selected(old('follow') == 1)>Follow</option>
                                            <option value="2" @selected(old('follow') == 2)>Unfollow</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-space-between">
                <a href="{{ route('post.catalouge.index') }}" class="btn btn-success mb-20 ">Cancel</a>
                <button type="submit" class="btn btn-primary mb-20 ">Save</button>
            </div>
    </form>
</x-backend.dashboard.layout>
