<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb title="Delete Member" />

    <form action="{{ route('user.catalouge.destroy', $userCatalouge->id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">
                        {{__('form.ObjectInfor', ['attribute' =>'Member Group'])}}
                    </h3>
                    <div class="pannel-description">
                        {{__('form.DelQuestion', ['attribute' => 'Member Group'])}}
                        <span class="text-danger">{{ $userCatalouge->name }}</span>
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
                                    :value="$userCatalouge->name ?? ''" :disabled="true" />

                                <x-backend.dashboard.form.input inputName="description" type="text" labelName='description'
                                    :value="$userCatalouge->description ?? ''" :disabled="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('user.catalouge.index') }}" class="btn btn-success mb-20 ">
                            {{__('form.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-danger mb-20 ">
                            {{__('form.save')}}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
