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
                <th>Image</th>
                <th>Name</th>
                <th>Canonical</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $post->id }}">
                    </td>
                    <td>
                        @if (!empty($post->image))
                            <img src="{{ base64_decode($post->image) }}" alt="country's flag"
                                class="table-img">
                        @endif
                    </td>
                    <td class="text-capitalize">{{ $post->name }}</td>
                    <td>{{ $post->canonical }}</td>
                    <td class="js-switch-{{ $post->id }}">
                        <input type="checkbox" class="js-switch status" data-model="post" data-field="publish"
                            data-modelId="{{ $post->id }}" value="{{ $post->publish }}"
                            @checked($post->publish == 1) />
                    </td>
                    <td>
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $posts->links('pagination::bootstrap-4') }}

</div>
