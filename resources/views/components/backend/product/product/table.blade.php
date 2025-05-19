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
            @foreach ($products as $product)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $product->id }}">
                    </td>
                    <td>
                        @if (!empty($product->image))
                            <img src="{{ base64_decode($product->image) }}" alt="country's flag"
                                class="table-img">
                        @endif
                    </td>
                    <td class="text-capitalize">{{ $product->name }}</td>
                    <td>{{ $product->canonical }}</td>
                    <td class="js-switch-{{ $product->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="product" data-field="publish"
                            data-modelId="{{ $product->id }}" value="{{ $product->publish }}"
                            @checked($product->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'product.update')
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'product.delete')
                            <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links('pagination::bootstrap-4') }}

</div>
