<x-backend.dashboard.layout>

    @php
        $url = isset($language) ? route('language.update', $language->id) : route('language.store');
        $title = isset($language) ? 'Edit Language' : 'Add Language';
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
                <div class="col-lg-5">
                    <h3 class="panel-title">Common Information</h3>
                    <div class="pannel-description">Enter group information to {{ isset($language) ? 'edit' : 'create new'}} language</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Common Information</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="name" type="text" labelName='name'
                                    :must="true" :value="$language->name ?? ''" />

                                <x-backend.dashboard.form.input inputName="canonical" type="text" labelName='canonical'
                                    :must="true" :value="$language->canonical ?? ''" />
                            </div>

                            <div class="row mt-20">
                                <x-backend.dashboard.form.upload labelName='Flag' :value="$language->image ?? '' "/>

                                <x-backend.dashboard.form.input inputName="description" type="text" labelName='description'
                                    :value="$language->description ?? ''" />
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{route('language.index')}}" class="btn btn-success mb-20 ">Cancel</a>
                        <button type="submit" class="btn btn-primary mb-20 ">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
