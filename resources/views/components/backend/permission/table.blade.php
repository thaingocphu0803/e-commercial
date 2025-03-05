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
                <th>{{__('table.name')}}</th>
                <th>{{__('table.canonical')}}</th>
                <th>{{__('table.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{ $permission->id }}">
                    </td>
                    <td class="text-capitalize">{{ $permission->name }}</td>
                    <td>{{ $permission->canonical }}</td>
                    <td>
                        <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('permission.delete', $permission->id) }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $permissions->links('pagination::bootstrap-4') }}

</div>
