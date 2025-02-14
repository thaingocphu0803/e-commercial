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
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{$user->id}}"></td>
                    <td>
                        <img src="../../../backend/img/a1.jpg" class="image img-cover" alt="user's avatar">
                    </td>
                    <td>
                        <div class="user-information text-capitalize"><strong>Fullname</strong>: {{ $user->name }}
                        </div>
                        <div class="user-information"><strong>Email</strong>: {{ $user->email }}</div>
                        <div class="user-information"><strong>Phone</strong>: {{ $user->phone }}</div>
                    </td>
                    <td>
                        <div class="user-address">{{ $user->address }}</div>
                        {{-- <div class="user-address"><strong>Ward</strong>: Phu Thuan</div>
                        <div class="user-address"><strong>District</strong>: 7</div>
                        <div class="user-address"><strong>City</strong>: Ho Chi Minh</div> --}}
                    </td>
                    <td class="js-switch-{{$user->id}}">
                        <input
                            type="checkbox"
                            class="js-switch status"
                            data-model="user"
                            data-field="publish"
                            data-modelId="{{$user->id}}"
                            value="{{$user->publish}}"
                            @checked($user->publish == 1) />
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{route('user.delete', $user->id)}}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links('pagination::bootstrap-4') }}

</div>
