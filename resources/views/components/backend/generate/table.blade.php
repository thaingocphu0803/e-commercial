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
                <th>{{ __('table.name') }}</th>
                <th class="text-center">{{ __('table.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($generates as $generate)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{ $generate->id }}">
                    </td>
                    <td class="text-capitalize">{{ $generate->name }}</td>
                    <td class="text-center">
                        @can('modules', 'generate.update')
                            <a href="{{ route('generate.edit', $generate->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'generate.delete')
                            <a href="{{ route('generate.delete', $generate->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $generates->links('pagination::bootstrap-4') }}

</div>
