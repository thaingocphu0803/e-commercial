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
            @foreach ($productCatalouges as $productCatalouge)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $productCatalouge->id }}">
                    </td>
                    <td>
                        @if (!empty($productCatalouge->image))
                            <img src="{{ base64_decode($productCatalouge->image) }}" alt="country's flag"
                                class="table-img">
                        @endif
                    </td>
                    <td class="text-capitalize">{{ $productCatalouge->name }}</td>
                    <td>{{ $productCatalouge->canonical }}</td>
                    <td class="js-switch-{{ $productCatalouge->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="productCatalouge" data-field="publish"
                            data-modelId="{{ $productCatalouge->id }}" value="{{ $productCatalouge->publish }}"
                            @checked($productCatalouge->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'product.catalouge.update')
                            <a href="{{ route('product.catalouge.edit', $productCatalouge->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'product.catalouge.delete')
                            <a href="{{ route('product.catalouge.delete', $productCatalouge->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $productCatalouges->links('pagination::bootstrap-4') }}

</div>
