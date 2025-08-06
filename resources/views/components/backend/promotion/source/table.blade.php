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
                <th class="text-center w-80">{{ __('custom.keyword') }}</th>
                <th class="text-center w-80">{{ __('custom.description') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sources as $source)
                <tr id="{{ $source->id }}">

                    <td>
                        <input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $source->id }}" />
                    </td>

                    <td class="text-capitalize">{{$source->name}}</td>
                    <td>{{$source->keyword}}</td>
                    <td>{{$source->description}}</td>
                    <td class="js-switch-{{ $source->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="source" data-field="publish"
                            data-modelId="{{ $source->id }}" value="{{ $source->publish }}"
                            @checked($source->publish == 1) />
                    </td>

                    <td class="text-center">

                        @can('modules', 'source.update')
                            <a href="{{ route('source.edit', $source->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'source.delete')
                            <a href="{{ route('source.delete', $source->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $sources->links('pagination::bootstrap-4') }}

</div>
