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
                <th>{{ __('table.image') }}</th>
                <th>{{ __('table.name') }}</th>
                <th>{{ __('table.canonical') }}</th>
                <th class="text-center">{{ __('table.active') }}</th>
                <th class="text-center">{{ __('table.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attrCatalouges as $attrCatalouge)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $attrCatalouge->id }}">
                    </td>
                    <td>
                        @if (!empty($attrCatalouge->image))
                            <img src="{{ base64_decode($attrCatalouge->image) }}" alt="country's flag"
                                class="table-img">
                        @endif
                    </td>
                    <td class="text-capitalize">{{ $attrCatalouge->name }}</td>
                    <td>{{ $attrCatalouge->canonical }}</td>
                    <td class="js-switch-{{ $attrCatalouge->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="attrCatalouge" data-field="publish"
                            data-modelId="{{ $attrCatalouge->id }}" value="{{ $attrCatalouge->publish }}"
                            @checked($attrCatalouge->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'attr.catalouge.update')
                            <a href="{{ route('attr.catalouge.edit', $attrCatalouge->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'attr.catalouge.delete')
                            <a href="{{ route('attr.catalouge.delete', $attrCatalouge->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $attrCatalouges->links('pagination::bootstrap-4') }}

</div>
