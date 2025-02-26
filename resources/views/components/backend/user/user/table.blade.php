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
                <th class="avt-col">Avatar</th>
                <th>Information</th>
                <th>Address</th>
                <th>Group</th>
                <th>Active</th>
                <th>Action</th>
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
                        <div class="user-information text-capitalize"><strong>Fullname</strong>: {{ $user->name }}
                        </div>
                        <div class="user-information"><strong>Email</strong>: {{ $user->email }}</div>
                        <div class="user-information"><strong>Phone</strong>: {{ $user->phone }}</div>
                    </td>
                    <td>
                        @if (optional($user->province)->name)
                            <div class="user-address"><strong>City</strong>{{ $user->province->name }}</div>
                        @endif

                        @if (optional($user->district)->name)
                            <div class="user-address"><strong>District</strong>{{ $user->district->name }}</div>
                        @endif

                        @if (optional($user->ward)->name)
                            <div class="user-address"><strong>Ward</strong>{{ $user->ward->name }}</div>
                        @endif

                        @if ($user->address)
                            <div class="user-address"><strong>Address</strong>{{ $user->address }}</div>
                        @endif
                    </td>
                    <td class="text-capitalize">{{ $user->userCatalouge->name }}</td>
                    <td class="js-switch-{{ $user->id }}">
                        <input type="checkbox" class="js-switch status" data-model="user" data-field="publish"
                            data-modelId="{{ $user->id }}" value="{{ $user->publish }}"
                            @checked($user->publish == 1) />
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links('pagination::bootstrap-4') }}

</div>
