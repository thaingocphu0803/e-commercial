<x-backend.dashboard.layout>

    <x-backend.dashboard.breadcrumb :title="__('table.PermissionAssignment')" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <form action="{{ route('user.catalouge.updatePermission') }}" method="POST" class="box">
        @csrf

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Cấp quyền</h5>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th></th>
                                    @foreach ($userCatalouges as $userCatalouge)
                                        <th class="text-center">{{ $userCatalouge->name }}</th>
                                    @endforeach
                                </thead>

                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->name }}</td>
                                            @foreach ($userCatalouges as $userCatalouge)
                                            @php
                                            @endphp
                                                <td class="text-center">
                                                    <input
                                                        @checked(
                                                                $userCatalouge
                                                                ->permissions
                                                                ->pluck('pivot.permission_id')
                                                                ->contains($permission->id)
                                                            )
                                                        class="check-table"
                                                        type="checkbox"
                                                        name="permission[{{$userCatalouge->id}}][]"
                                                        id=""
                                                        value="{{$permission->id}}"
                                                    >
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-space-between mt-20">
                <a href="{{ route('user.catalouge.index') }}" class="btn btn-success mb-20 ">
                    {{ __('form.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary mb-20 ">
                    {{ __('form.save') }}
                </button>
            </div>
        </div>
    </form>

</x-backend.dashboard.layout>
