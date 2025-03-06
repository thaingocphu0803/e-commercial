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
                <th>{{ __('table.flag') }}</th>
                <th>{{ __('table.name') }}</th>
                <th>{{ __('table.description') }}</th>
                <th class="text-center">{{ __('table.active') }}</th>
                <th class="text-center">{{ __('table.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($languages as $language)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{ $language->id }}">
                    </td>
                    <td>
                        @if (!empty($language->image))
                            <img src="{{ base64_decode($language->image) }}" alt="country's flag" class="table-img">
                        @endif
                    </td>
                    <td class="text-capitalize">{{ $language->name }}</td>
                    <td>{{ $language->description }}</td>
                    <td class="js-switch-{{ $language->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="language" data-field="publish"
                            data-modelId="{{ $language->id }}" value="{{ $language->publish }}"
                            @checked($language->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'language.update')
                            <a href="{{ route('language.edit', $language->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'language.delete')
                            <a href="{{ route('language.delete', $language->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $languages->links('pagination::bootstrap-4') }}

</div>
