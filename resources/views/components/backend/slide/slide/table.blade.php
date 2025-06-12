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
                <th class="avt-col">{{ __('custom.catalougeName') }}</th>
                <th>{{ __('custom.keyword') }}</th>
                <th>{{ __('custom.listImage') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($slides as $slide)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{ $slide->id }}">
                    </td>
                    <td>{{ $slide->name }}</td>
                    <td>{{ $slide->keyword}}</td>
                    <td class="text-capitalize text-center">--</td>
                    <td class="js-switch-{{ $slide->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="user" data-field="publish"
                            data-modelId="{{ $slide->id }}" value="{{ $slide->publish }}"
                            @checked($slide->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'user.update')
                            <a href="{{ route('user.edit', $slide->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'user.delete')
                            <a href="{{ route('user.delete', $slide->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $slides->links('pagination::bootstrap-4') }}

</div>
