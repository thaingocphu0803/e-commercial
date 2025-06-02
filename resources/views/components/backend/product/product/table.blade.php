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
                <th>{{ __('custom.name') }}</th>
                <th class="text-center w-80">{{ __('custom.order') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr id="{{ $product->id }}">

                    <td>
                        <input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $product->id }}" />
                    </td>

                    <td class="text-capitalize">
                        <div class="flex flex-middle gap-10">
                            @if (!empty($product->image))
                                <div class="image">
                                    <div class="image-cover">
                                        <img src="{{ base64_decode($product->image) }}" alt="country's flag"
                                            class="table-img">
                                    </div>
                                </div>
                            @endif
                            <div class="main-info">
                                <div class="name">
                                    <span class="main-title">
                                        {{ $product->name }}
                                    </span>
                                </div>
                                <div class="catalouge flex gap-10">
                                    <span
                                        class="text-danger">{{ __('custom.objectGroup', ['attribute' => __('custom.catalouge')]) }}:</span>
                                    @foreach ($product->productCatalouges as $productCatalouge)
                                        <a href="#"
                                            title="">{{ $productCatalouge->languages->pluck('pivot.name')->implode(',') }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <input type="text" name="order" value="{{ $product->order }}"
                            class="form-control sort-sorder text-center" data-id="{{ $product->id }}"
                            data-model="product">
                    </td>

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
