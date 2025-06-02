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
            @foreach ($postCatalouges as $postCatalouge)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $postCatalouge->id }}">
                    </td>
                    <td>
                        @if (!empty($postCatalouge->image))
                            <img src="{{ base64_decode($postCatalouge->image) }}" alt="country's flag"
                                class="table-img">
                        @endif
                    </td>
                    <td class="text-capitalize">{{ $postCatalouge->name }}</td>
                    <td>{{ $postCatalouge->canonical }}</td>
                    <td class="js-switch-{{ $postCatalouge->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="postCatalouge" data-field="publish"
                            data-modelId="{{ $postCatalouge->id }}" value="{{ $postCatalouge->publish }}"
                            @checked($postCatalouge->publish == 1) />
                    </td>
                    <td class="text-center">
                        @can('modules', 'post.catalouge.update')
                            <a href="{{ route('post.catalouge.edit', $postCatalouge->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'post.catalouge.delete')
                            <a href="{{ route('post.catalouge.delete', $postCatalouge->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $postCatalouges->links('pagination::bootstrap-4') }}

</div>
