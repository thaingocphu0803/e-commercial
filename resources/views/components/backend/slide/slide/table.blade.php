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
                <th class="text-center">{{ __('custom.catalougeName') }}</th>
                <th class="text-center">{{ __('custom.keyword') }}</th>
                <th class="text-center">{{ __('custom.listImage') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($slides as $slide)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{ $slide->id }}">
                    </td>
                    <td class="text-center">{{ $slide->name }}</td>
                    <td class="text-center">{{ $slide->keyword }}</td>
                    <td class="text-capitalize text-center">
                        @php
                            $item = json_decode($slide->item, true);
                        @endphp

                        @foreach ($item['image'] as $src)
                                <img class="img-cover table-img" src="{{ $src }}" alt="">
                        @endforeach
                    </td>
                    <td class="js-switch-{{ $slide->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="slide" data-field="publish"
                            data-modelId="{{ $slide->id }}" value="{{ $slide->publish }}"
                            @checked($slide->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'slide.update')
                            <a href="{{ route('slide.edit', $slide->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'slide.delete')
                            <a href="{{ route('slide.delete', $slide->id) }}" class="btn btn-danger">
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
