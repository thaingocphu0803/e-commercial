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
                <th>{{__('table.image')}}</th>
                <th>{{__('table.name')}}</th>
                <th>{{__('table.canonical')}}</th>
                <th>{{__('table.active')}}</th>
                <th>{{__('table.action')}}</th>
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
                    <td class="js-switch-{{ $postCatalouge->id }}">
                        <input type="checkbox" class="js-switch status" data-model="postCatalouge" data-field="publish"
                            data-modelId="{{ $postCatalouge->id }}" value="{{ $postCatalouge->publish }}"
                            @checked($postCatalouge->publish == 1) />
                    </td>
                    <td>
                        <a href="{{ route('post.catalouge.edit', $postCatalouge->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('post.catalouge.delete', $postCatalouge->id) }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $postCatalouges->links('pagination::bootstrap-4') }}

</div>
