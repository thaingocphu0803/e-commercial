<x-slot:heading>
    <link href="{{asset('backend/css/plugins/switchery/switchery.css')}}" rel="stylesheet">
</x-slot:heading>

<x-slot:script>
    <script src="{{asset('backend/js/plugins/switchery/switchery.js')}}"></script>

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
                <th>{{ __('custom.numCustomer') }}</th>
                <th>{{ __('custom.description') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customerCatalouges as $customerCatalouge)
                <tr>
                    <td>
                        <input
                            type="checkbox"
                            name="input"
                            class="checkItem check-table"
                            value="{{ $customerCatalouge->id }}"
                        >
                    </td>
                    <td class="text-capitalize">{{ $customerCatalouge->name }}</td>
                    <td class="text-capitalize">{{ $customerCatalouge->users_count }}</td>
                    <td>{{ $customerCatalouge->description }}</td>
                    <td class="js-switch-{{ $customerCatalouge->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="customerCatalouge" data-field="publish"
                            data-modelId="{{ $customerCatalouge->id }}" value="{{ $customerCatalouge->publish }}"
                            @checked($customerCatalouge->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'customer.catalouge.update')
                            <a href="{{ route('customer.catalouge.edit', $customerCatalouge->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'customer.catalouge.delete')
                            <a href="{{ route('customer.catalouge.delete', $customerCatalouge->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customerCatalouges->links('pagination::bootstrap-4') }}

</div>
