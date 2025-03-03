<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb title="Delete Post" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('post.destroy', $post->post_id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('form.ObjectInfor', ['attribute' => 'Post Catalouge'])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('form.DelQuestion', ['attribute' => 'Post Catalouge'])}}
                        <span class="text-danger">{{ $post->name }}</span>
                    </div>
                    <div class="pannel-description">
                        {{__('form.DelNote')}}
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.dashboard.form.input inputName="name" type="text" labelName='name'
                                    :value="$post->name ?? ''" :readOnly="true" />

                                <x-backend.dashboard.form.input inputName="canonical" type="text"
                                    labelName='canonical' :value="$post->canonical ?? ''" :readOnly="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('post.index') }}" class="btn btn-success mb-20 ">
                            {{__('form.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-danger mb-20 ">
                            {{__('form.delete')}}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
