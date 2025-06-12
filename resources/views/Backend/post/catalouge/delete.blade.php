<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb
        :title="__('custom.delObject', ['attribute'=>__('custom.postGroup')])"
    />

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
    <form action="{{ route('post.catalouge.destroy', $postCatalouge->post_catalouge_id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('custom.ObjectInfor', ['attribute' => __('custom.postGroup')])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('custom.DelQuestion', ['attribute' => __('custom.postGroup')])}}
                        <span class="text-danger">{{ $postCatalouge->name }}</span>
                    </div>
                    <div class="pannel-description">{{__('custom.DelNote')}}</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="name" type="text" :labelName="__('custom.name')"
                                    :value="$postCatalouge->name ?? ''" :readOnly="true" />

                                <x-backend.dashboard.form.input inputName="canonical" type="text"
                                :labelName="__('custom.canonical')"   :value="$postCatalouge->canonical ?? ''" :readOnly="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('post.catalouge.index') }}" class="btn btn-success mb-20 ">
                            {{__('custom.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-danger mb-20 ">
                            {{__('custom.delete')}}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
</x-backend.dashboard.layout>
