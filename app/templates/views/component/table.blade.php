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
                <th>{{ __('custom.image') }}</th>
                <th>{{ __('custom.name') }}</th>
                <th>{{ __('custom.canonical') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach (${moduleName}s as ${moduleName})
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ ${moduleName}->id }}">
                    </td>
                    <td>
                        @if (!empty(${moduleName}->image))
                            <img src="{{ base64_decode(${moduleName}->image) }}" alt="country's flag"
                                class="table-img">
                        @endif
                    </td>
                    <td class="text-capitalize">{{ ${moduleName}->name }}</td>
                    <td>{{ ${moduleName}->canonical }}</td>
                    <td class="js-switch-{{ ${moduleName}->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="{moduleName}" data-field="publish"
                            data-modelId="{{ ${moduleName}->id }}" value="{{ ${moduleName}->publish }}"
                            @checked(${moduleName}->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', '{routerPath}.update')
                            <a href="{{ route('{routerPath}.edit', ${moduleName}->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', '{routerPath}.delete')
                            <a href="{{ route('{routerPath}.delete', ${moduleName}->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ ${moduleName}s->links('pagination::bootstrap-4') }}

</div>
