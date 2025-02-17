<x-backend.dashboard.layout>


    <x-backend.dashboard.breadcrumb title="Delete Member" />

    <form action="{{ route('user.catalouge.destroy', $userCatalouge->id) }}" method="POST" class="box">
        @csrf
        @method('delete')

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="panel-title">Member Information</h3>
                    <div class="pannel-description">Do you want delete member group with name: <span class="text-danger">{{ $userCatalouge->name }}</span></div>
                    <div class="pannel-description">Note: You can not recover after deleting.</div>

                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <x-backend.user.form.input inputName="name" type="text" labelName='name'
                                    :value="$userCatalouge->name ?? ''" :disabled="true" />

                                <x-backend.user.form.input inputName="description" type="text" labelName='description'
                                    :value="$userCatalouge->description ?? ''" :disabled="true" />

                            </div>

                        </div>

                    </div>
                    <div class="flex flex-space-between">
                        <a href="{{ route('user.catalouge.index') }}" class="btn btn-success mb-20 ">Cancel</a>
                        <button type="submit" class="btn btn-danger mb-20 ">Delete</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
