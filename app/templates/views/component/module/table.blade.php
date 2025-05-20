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
                <th>{{ __('table.name') }}</th>
                <th class="text-center w-80">{{ __('table.order') }}</th>
                <th class="text-center">{{ __('table.active') }}</th>
                <th class="text-center">{{ __('table.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach (${moduleName}s as ${moduleName})
                <tr id="{{ ${moduleName}->id }}">

                    <td>
                        <input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ ${moduleName}->id }}" />
                    </td>

                    <td class="text-capitalize">
                        <div class="flex flex-middle gap-10">
                            @if (!empty(${moduleName}->image))
                                <div class="image">
                                    <div class="image-cover">
                                        <img src="{{ base64_decode(${moduleName}->image) }}" alt="country's flag"
                                            class="table-img">
                                    </div>
                                </div>
                            @endif
                            <div class="main-info">
                                <div class="name">
                                    <span class="main-title">
                                        {{ ${moduleName}->name }}
                                    </span>
                                </div>
                                <div class="catalouge flex gap-10">
                                    <span
                                        class="text-danger">{{ __('dashboard.objectGroup', ['object' => __('table.catalouge')]) }}:</span>
                                    @foreach (${moduleName}->{moduleName}Catalouges as ${moduleName}Catalouge)
                                        <a href="#"
                                            title="">{{ ${moduleName}Catalouge->languages->pluck('pivot.name')->implode(',') }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <input type="text" name="order" value="{{ ${moduleName}->order }}"
                            class="form-control sort-sorder text-center" data-id="{{ ${moduleName}->id }}"
                            data-model="{moduleName}">
                    </td>

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
