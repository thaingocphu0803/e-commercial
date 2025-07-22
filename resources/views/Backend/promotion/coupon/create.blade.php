<x-backend.dashboard.layout>

    <x-slot:heading>
        <link href="../../../backend/css/plugins/switchery/switchery.css" rel="stylesheet">
    </x-slot:heading>
    <x-slot:script>
        <script src="../../../backend/js/plugins/switchery/switchery.js"></script>
    </x-slot:script>

    @php
        $url = isset($product) ? route('product.update', $product->product_id) : route('product.store');

        $title = isset($product)
            ? __('custom.editObject', ['attribute' => __('custom.product')])
            : __('custom.addObject', ['attribute' => __('custom.product')]);

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

<div class="row">
    <form action="{{ $url }}" method="POST" class="box" id="product_form">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-9">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('custom.ObjectInfor', ['attribute' => __('custom.common')]) }}
                            </h5>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-row flex flex-col gap-10">
                                            <x-backend.dashboard.form.input inputName="name" type="text"
                                                :labelName="__('custom.name')" :must="true" rowLength="12" :value="$product->name ?? ''" />

                                            <x-backend.dashboard.form.input inputName="description" type="text"
                                                :labelName="__('custom.description')" rowLength="12" :value="$product->description ?? ''" tag='textarea' />


                                            <x-backend.dashboard.form.input inputName="content" type="text"
                                                :labelName="__('custom.content')" rowLength="12" :value="$product->content ?? ''" tag='textarea' />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <x-backend.dashboard.album :album="$product->album ?? ''" />

                    <x-backend.dashboard.variant :list-attr="$listAttr" :product="$product ?? ''" />
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('custom.seoSet') }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="seo-wrapper flex flex-col gap-10">
                                <x-backend.dashboard.form.seo :labelName="__('custom.title')" inputName='meta_title'
                                    :value="$product->meta_title ?? ''" />
                                <x-backend.dashboard.form.seo :labelName="__('custom.keyword')" inputName='meta_keyword'
                                    :value="$product->meta_keyword ?? ''" />
                                <x-backend.dashboard.form.seo :labelName="__('custom.description')" inputName='meta_description'
                                    tag='textarea' :value="$product->meta_description ?? ''" />
                                <x-backend.dashboard.form.seo :labelName="__('custom.canonical')" inputName='canonical'
                                    :must="true" :value="$product->canonical ?? ''" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('custom.chooseObject', ['attribute' => __('custom.parentSection')]) }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row flex flex-col gap-10">
                                <x-backend.dashboard.form.select :labelName="__('custom.parentSection')" name="product_catalouge_id"
                                    rowLength="12" :data="$listNode" :must="true" :value="$product->product_catalouge_id ?? ''" />

                                <x-backend.dashboard.form.multiselect :labelName="__('custom.subSection')" name="catalouge" rowLength="12"
                                    :data="$listNode" :value="$product->catalouges ?? []" :parent="$product->product_catalouge_id ?? ''" />
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('custom.ObjectInfor', ['attribute' => __('custom.common')]) }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row flex flex-col gap-10">
                                <x-backend.dashboard.form.input
                                    inputName="code"
                                    rowLength="12"
                                    type="text"
                                    :labelName="__('custom.code')"
                                    {{-- :must="true" --}}
                                    :value="time()"
                                />
                                <x-backend.dashboard.form.input
                                    inputName="price"
                                    rowLength="12"
                                    type="text"
                                    :labelName="__('custom.price')"
                                    {{-- :must="true" --}}
                                    {{-- :value="$user->email ?? ''" --}}
                                />
                                <x-backend.dashboard.form.input
                                    inputName="origin"
                                    rowLength="12"
                                    type="text"
                                    :labelName="__('custom.origin')"
                                    {{-- :must="true" --}}
                                    {{-- :value="$user->email ?? ''" --}}
                                />
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('custom.chooseObject', ['attribute' => __('custom.language')]) }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <x-backend.dashboard.form.select :labelName="__('custom.language')" name="language_id"
                                            rowLength="12" :data="$languages" :must="true" :value="$product->language_id ?? ''" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('custom.chooseObject', ['attribute' => __('custom.productImage')]) }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-backend.dashboard.form.upload rowLength="12" :labelName="__('custom.productImage')"
                                        :value="$product->image ?? ''" />
                                    <img class="col-lg-12 hidden" id="img_show" :alt="__('custom.productImage')"
                                        height="250px">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('custom.advanceSet') }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12 flex flex-col gap-10">
                                    <div class="flex gap-10">
                                        <select name="publish" class="form-control  select2">
                                            <option disabled selected>
                                                {{ __('custom.chooseObject', ['attribute' => __('custom.productStatus')]) }}
                                            </option>
                                            <option value="1" @selected(old('publish', $publish) == 1)>
                                                {{ __('custom.published') }}
                                            </option>
                                            <option value="2" @selected(old('publish', $publish) == 2)>
                                                {{ __('custom.private') }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="flex gap-10">
                                        <select name="follow" class="form-control  select2">
                                            <option disabled selected>
                                                {{ __('custom.chooseObject', ['attribute' => __('custom.productVision')]) }}
                                            </option>
                                            <option value="1" @selected(old('follow', $follow) == 1)>
                                                {{ __('custom.follow') }}
                                            </option>
                                            <option value="2" @selected(old('follow', $follow) == 2)>
                                                {{ __('custom.unfollow') }}
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
                    {{ __('custom.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary mb-20 ">
                    {{ __('custom.save') }}
                </button>
            </div>
    </form>
</div>
</x-backend.dashboard.layout>
