<x-slot:heading>
    <link href="../../../backend/css/plugins/switchery/switchery.css" rel="stylesheet">
</x-slot:heading>

<x-slot:script>
    <script src="../../../backend/js/plugins/switchery/switchery.js"></script>


    <script>
        $('.js-switch').each((index, element) => {
            var switchery = new Switchery(element, {
                color: '#1AB394'
            });
        });
    </script>
</x-slot:script>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>

                <th><input type="checkbox" class="checkAll check-table" name="input"></th>
                <th class="avt-col">{{ __('table.avatar') }}</th>
                <th>{{ __('table.information') }}</th>
                <th>{{ __('table.address') }}</th>
                <th class="text-center">{{ __('table.group') }}</th>
                <th class="text-center">{{ __('table.active') }}</th>
                <th class="text-center">{{ __('table.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{ $user->id }}">
                    </td>
                    <td>
                        @if (!empty($user->image))
                            <img src="{{ base64_decode($user->image) }}" alt="user's image" class="table-img">
                        @endif
                    </td>
                    <td>
                        <div class="user-information text-capitalize"><strong>{{ __('table.fullname') }}</strong>:
                            {{ $user->name }}
                        </div>
                        <div class="user-information"><strong>{{ __('table.email') }}</strong>: {{ $user->email }}
                        </div>
                        <div class="user-information"><strong>{{ __('table.phone') }}</strong>: {{ $user->phone }}
                        </div>
                    </td>
                    <td>
                        @if (optional($user->province)->name)
                            <div class="user-address">
                                <strong>{{ __('table.city') }}</strong>{{ $user->province->name }}
                            </div>
                        @endif

                        @if (optional($user->district)->name)
                            <div class="user-address">
                                <strong>{{ __('table.district') }}</strong>{{ $user->district->name }}
                            </div>
                        @endif

                        @if (optional($user->ward)->name)
                            <div class="user-address">
                                <strong>{{ __('table.ward') }}</strong>{{ $user->ward->name }}
                            </div>
                        @endif

                        @if ($user->address)
                            <div class="user-address">
                                <strong>{{ __('table.address') }}</strong>{{ $user->address }}
                            </div>
                        @endif
                    </td>
                    <td class="text-capitalize text-center">{{ $user->userCatalouge->name }}</td>
                    <td class="js-switch-{{ $user->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="user" data-field="publish"
                            data-modelId="{{ $user->id }}" value="{{ $user->publish }}"
                            @checked($user->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'user.update')
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'user.delete')
                            <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links('pagination::bootstrap-4') }}

</div>
