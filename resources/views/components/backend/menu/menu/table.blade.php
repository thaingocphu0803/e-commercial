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
                <th class="text-center">{{ __('custom.name') }}</th>
                <th class="text-center">{{ __('custom.keyword') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menuCatalouges as $menuCatalouge)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{ $menuCatalouge->id }}">
                    </td>
                    <td class="text-center">
                        {{ $menuCatalouge->name }}
                    </td>
                    <td class="text-center">
                        {{ $menuCatalouge->keyword }}
                    </td>
                    <td class="js-switch-{{ $menuCatalouge->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="menuCatalouge" data-field="publish"
                            data-modelId="{{ $menuCatalouge->id }}" value="{{ $menuCatalouge->publish }}"
                            @checked($menuCatalouge->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'menu.update')
                            <a href="{{ route('menu.edit', $menuCatalouge->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'menu.delete')
                            <a href="{{ route('menu.delete', $menuCatalouge->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{ $menus->links('pagination::bootstrap-4') }} --}}

</div>
