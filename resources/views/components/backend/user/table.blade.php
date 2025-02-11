<x-slot:heading>
    <link href="../../../backend/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="../../../backend/css/plugins/switchery/switchery.css" rel="stylesheet">
</x-slot:heading>

<x-slot:script>
    <script src="../../../backend/js/plugins/iCheck/icheck.min.js"></script>
    <script src="../../../backend/js/plugins/switchery/switchery.js"></script>


    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

        // var elements = document.querySelector('.js-switch');

        $('.js-switch').each((index,element) => {
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

                <th><input type="checkbox" class="i-checks" name="input"></th>
                <th class="avt-col">Avatar</th>
                <th>Information</th>
                <th>Address</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user )
            <tr>
                <td><input type="checkbox" checked class="i-checks" name="input"></td>
                <td>
                    <img src="../../../backend/img/a1.jpg" class="image img-cover" alt="user's avatar">
                </td>
                <td>
                    <div class="user-information"><strong>Fullname</strong>: {{$user->name}}</div>
                    <div class="user-information"><strong>Email</strong>: {{$user->email}}</div>
                    <div class="user-information"><strong>Phone</strong>: {{$user->phone}}</div>
                </td>
                <td>
                    <div class="user-address">{{$user->address}}</div>
                    {{-- <div class="user-address"><strong>Ward</strong>: Phu Thuan</div>
                    <div class="user-address"><strong>District</strong>: 7</div>
                    <div class="user-address"><strong>City</strong>: Ho Chi Minh</div> --}}

                </td>
                <td>
                    <input type="checkbox" class="js-switch" checked />
                </td>
                <td>
                    <a href="#" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-danger">
                        <ic class="fa fa-trash"></i>
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$users->links('pagination::bootstrap-4')}}

</div>
