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

@php
    use Carbon\Carbon;
    $promotionType = array_column(__('module.promotion'), 'name', 'id');
@endphp
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" class="checkAll check-table" name="input"></th>
                <th>{{ __('custom.name') }}</th>
                <th class="text-center">{{ __('custom.typePromotion') }}</th>
                <th class="text-center">{{ __('custom.startDate') }}</th>
                <th class="text-center">{{ __('custom.endDate') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promotions as $promotion)
                @php
                    $expired = false;
                    $carbon_start_date = Carbon::parse($promotion->start_date);
                    $carbon_end_date = is_null($promotion->end_date)
                        ? Carbon::create(9999, 12, 31)
                        : Carbon::parse($promotion->end_date);
                    if ($carbon_start_date->greaterThanOrEqualTo($carbon_end_date)) {
                        $expired = true;
                    }
                @endphp
                <tr id="{{ $promotion->id }}">

                    <td>
                        <input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $promotion->id }}" />
                    </td>
                    <td>
                        <div class="text-sm mb-10">
                            {{ $promotion->name}}
                            @if ($expired)
                                <span class="ml-10 label-red-500">{{ __('custom.expired') }}</span>
                            @endif
                        </div>
                        <span class="label-navy-500">{{ __('custom.code') . ': ' . $promotion->code }}</span>
                    </td>

                    <td class="text-center">{{ $promotionType[$promotion->method] }}</td>

                    <td class="text-center">{{ $promotion->start_date }}</td>

                    <td class="text-center">{{ $promotion->end_date ?? __('custom.notEndTime') }}</td>
                    <td class="js-switch-{{ $promotion->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="promotion" data-field="publish"
                            data-modelId="{{ $promotion->id }}" value="{{ $promotion->publish }}"
                            @checked($promotion->publish == 1) />
                    </td>

                    <td class="text-center">

                        @can('modules', 'promotion.update')
                            <a href="{{ route('promotion.edit', $promotion->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'promotion.delete')
                            <a href="{{ route('promotion.delete', $promotion->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $promotions->links('pagination::bootstrap-4') }}

</div>
