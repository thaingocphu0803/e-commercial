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
                <th class="text-center w-80">{{ __('custom.order') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attrs as $attr)
                <tr id="{{ $attr->id }}">

                    <td>
                        <input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $attr->id }}" />
                    </td>

                    <td class="text-capitalize">
                        <div class="flex flex-middle gap-10">
                            @if (!empty($attr->image))
                                <div class="image">
                                    <div class="image-cover">
                                        <img src="{{ base64_decode($attr->image) }}" alt="country's flag"
                                            class="table-img">
                                    </div>
                                </div>
                            @endif
                            <div class="main-info">
                                <div class="name">
                                    <span class="main-title">
                                        {{ $attr->name }}
                                    </span>
                                </div>
                                <div class="catalouge flex gap-10">
                                    <span
                                        class="text-danger">{{ __('custom.objectGroup', ['attribute' => __('custom.catalouge')]) }}:</span>
                                    @foreach ($attr->attrCatalouges as $attrCatalouge)
                                        <a href="#"
                                            title="">{{ $attrCatalouge->languages->pluck('pivot.name')->implode(',') }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <input type="text" name="order" value="{{ $attr->order }}"
                            class="form-control sort-sorder text-center" data-id="{{ $attr->id }}"
                            data-model="attr">
                    </td>

                    <td class="js-switch-{{ $attr->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="attr" data-field="publish"
                            data-modelId="{{ $attr->id }}" value="{{ $attr->publish }}"
                            @checked($attr->publish == 1) />
                    </td>

                    <td class="text-center">

                        @can('modules', 'attr.update')
                            <a href="{{ route('attr.edit', $attr->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'attr.delete')
                            <a href="{{ route('attr.delete', $attr->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $attrs->links('pagination::bootstrap-4') }}

</div>
