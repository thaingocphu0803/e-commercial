<x-backend.dashboard.layout>

    <x-slot:heading>
        <script src="https://cdn.tiny.cloud/1/45tp955r5rsk9zjmoshrh28werz7a8oc0urf8hnf0tnavqre/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
        <link href="../../../backend/css/plugins/switchery/switchery.css" rel="stylesheet">
    </x-slot:heading>
    <x-slot:script>
        <script src="../../../backend/js/plugins/switchery/switchery.js"></script>
    </x-slot:script>

    @php
        $url = isset($product) ? route('product.update', $product->product_id) : route('product.store');

        $title = isset($product)
            ? __('form.editObject', ['attribute' => __('dashboard.product')])
            : __('form.addObject', ['attribute' => __('dashboard.product')]);

        $publish = $product->publish ?? '';
        $follow = $product->follow ?? '';
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



    <form action="{{ $url }}" method="POST" class="box" id="product_form">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-9">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('form.ObjectInfor', ['attribute' => __('form.common')]) }}
                            </h5>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-row flex flex-col gap-10">
                                            <x-backend.dashboard.form.input inputName="name" type="text"
                                                :labelName="__('dashboard.name')" :must="true" rowLength="12" :value="$product->name ?? ''" />

                                            <x-backend.dashboard.form.input inputName="description" type="text"
                                                :labelName="__('dashboard.description')" rowLength="12" :value="$product->description ?? ''" tag='textarea' />


                                            <x-backend.dashboard.form.input inputName="content" type="text"
                                                :labelName="__('form.content')" rowLength="12" :value="$product->content ?? ''" tag='textarea' />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <x-backend.dashboard.album :album="$product->album ?? ''" />

                    <x-backend.dashboard.variant :list-attr="$listAttr" />
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('form.seoSet') }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="seo-wrapper flex flex-col gap-10">
                                <x-backend.dashboard.form.seo :labelName="__('form.title')" inputName='meta_title'
                                    :value="$product->meta_title ?? ''" />
                                <x-backend.dashboard.form.seo :labelName="__('form.keyword')" inputName='meta_keyword'
                                    :value="$product->meta_keyword ?? ''" />
                                <x-backend.dashboard.form.seo :labelName="__('dashboard.description')" inputName='meta_description'
                                    tag='textarea' :value="$product->meta_description ?? ''" />
                                <x-backend.dashboard.form.seo :labelName="__('dashboard.canonical')" inputName='canonical'
                                    :must="true" :value="$product->canonical ?? ''" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('form.chooseObject', ['attribute' => __('form.parentSection')]) }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row flex flex-col gap-10">
                                <x-backend.dashboard.form.select :labelName="__('form.parentSection')" name="product_catalouge_id"
                                    rowLength="12" :data="$listNode" :must="true" :value="$product->product_catalouge_id ?? ''" />

                                <x-backend.dashboard.form.multiselect :labelName="__('form.subSection')" name="catalouge" rowLength="12"
                                    :data="$listNode" :value="$product->catalouges ?? []" :parent="$product->product_catalouge_id ?? ''" />
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('form.ObjectInfor', ['attribute' => __('form.common')]) }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row flex flex-col gap-10">
                                <x-backend.dashboard.form.input
                                    inputName="code"
                                    rowLength="12"
                                    type="text"
                                    :labelName="__('form.code')"
                                    {{-- :must="true" --}}
                                    :value="time()"
                                />
                                <x-backend.dashboard.form.input
                                    inputName="price"
                                    rowLength="12"
                                    type="text"
                                    :labelName="__('form.price')"
                                    {{-- :must="true" --}}
                                    {{-- :value="$user->email ?? ''" --}}
                                />
                                <x-backend.dashboard.form.input
                                    inputName="origin"
                                    rowLength="12"
                                    type="text"
                                    :labelName="__('form.origin')"
                                    {{-- :must="true" --}}
                                    {{-- :value="$user->email ?? ''" --}}
                                />
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('form.chooseObject', ['attribute' => __('dashboard.language')]) }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <x-backend.dashboard.form.select :labelName="__('dashboard.language')" name="language_id"
                                            rowLength="12" :data="$languages" :must="true" :value="$product->language_id ?? ''" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('form.chooseObject', ['attribute' => __('form.productImage')]) }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-backend.dashboard.form.upload rowLength="12" :labelName="__('form.productImage')"
                                        :value="$product->image ?? ''" />
                                    <img class="col-lg-12 hidden" id="img_show" :alt="__('form.productImage')"
                                        height="250px">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('form.advanceSet') }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12 flex flex-col gap-10">
                                    <div class="flex gap-10">
                                        <select name="publish" class="form-control  select2">
                                            <option disabled selected>
                                                {{ __('form.chooseObject', ['attribute' => __('table.productStatus')]) }}
                                            </option>
                                            <option value="1" @selected(old('publish', $publish) == 1)>
                                                {{ __('form.published') }}
                                            </option>
                                            <option value="2" @selected(old('publish', $publish) == 2)>
                                                {{ __('form.private') }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="flex gap-10">
                                        <select name="follow" class="form-control  select2">
                                            <option disabled selected>
                                                {{ __('form.chooseObject', ['attribute' => __('form.productVision')]) }}
                                            </option>
                                            <option value="1" @selected(old('follow', $follow) == 1)>
                                                {{ __('form.follow') }}
                                            </option>
                                            <option value="2" @selected(old('follow', $follow) == 2)>
                                                {{ __('form.unfollow') }}
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
                <a href="{{ route('product.index') }}" class="btn btn-success mb-20 ">
                    {{ __('form.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary mb-20 ">
                    {{ __('form.save') }}
                </button>
            </div>
    </form>
</x-backend.dashboard.layout>
