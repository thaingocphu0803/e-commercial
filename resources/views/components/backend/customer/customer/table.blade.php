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
                <th class="avt-col">{{ __('custom.avatar') }}</th>
                <th>{{ __('custom.information') }}</th>
                <th>{{ __('custom.address') }}</th>
                <th class="text-center">{{ __('custom.group') }}</th>
                <th class="text-center">{{ __('custom.source') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{ $customer->id }}">
                    </td>
                    <td>
                        @if (!empty($customer->image))
                            <img src="{{ base64_decode($customer->image) }}" alt="customer's image" class="table-img">
                        @endif
                    </td>
                    <td>
                        <div class="customer-information text-capitalize"><strong>{{ __('custom.fullname') }}</strong>:
                            {{ $customer->name }}
                        </div>
                        <div class="customer-information"><strong>{{ __('custom.email') }}</strong>: {{ $customer->email }}
                        </div>
                        <div class="customer-information"><strong>{{ __('custom.phone') }}</strong>: {{ $customer->phone }}
                        </div>
                    </td>
                    <td>
                        @if (optional($customer->province)->name)
                            <div class="customer-address">
                                <strong>{{ __('custom.city') }}</strong> :{{ $customer->province->name }}
                            </div>
                        @endif

                        @if (optional($customer->district)->name)
                            <div class="customer-address">
                                <strong>{{ __('custom.district') }}</strong> :{{ $customer->district->name }}
                            </div>
                        @endif

                        @if (optional($customer->ward)->name)
                            <div class="customer-address">
                                <strong>{{ __('custom.ward') }}</strong> :{{ $customer->ward->name }}
                            </div>
                        @endif

                        @if ($customer->address)
                            <div class="customer-address">
                                <strong>{{ __('custom.address') }}</strong> :{{ $customer->address }}
                            </div>
                        @endif
                    </td>
                    <td class="text-capitalize text-center">{{ $customer->customerCatalouge->name }}</td>
                    <td class="text-capitalize text-center">{{ $customer->source->name }}</td>
                    <td class="js-switch-{{ $customer->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="customer" data-field="publish"
                            data-modelId="{{ $customer->id }}" value="{{ $customer->publish }}"
                            @checked($customer->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'customer.update')
                            <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'customer.delete')
                            <a href="{{ route('customer.delete', $customer->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->links('pagination::bootstrap-4') }}

</div>
