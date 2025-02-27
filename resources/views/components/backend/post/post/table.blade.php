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
                <th>Name</th>
                <th class="text-center w-80">Order</th>
                <th class="text-center">Active</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr id="{{ $post->id }}">

                    <td>
                        <input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $post->id }}" />
                    </td>

                    <td class="text-capitalize">
                        <div class="flex flex-middle gap-10">
                            @if (!empty($post->image))
                                <div class="image">
                                    <div class="image-cover">
                                        <img src="{{ base64_decode($post->image) }}" alt="country's flag"
                                            class="table-img">
                                    </div>
                                </div>
                            @endif
                            <div class="main-info">
                                <div class="name">
                                    <span class="main-title">
                                        {{ $post->name }}
                                    </span>
                                </div>
                                <div class="catalouge flex gap-10">
                                    <span class="text-danger">Catalouge Group:</span>
                                    @foreach ($post->postCatalouges as $postCatalouge)
                                    <a href="#" title="">{{$postCatalouge->languages->pluck('pivot.name')->implode(',')}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <input type="text" name="order" value="{{ $post->order }}"
                            class="form-control sort-sorder text-center" data-id="{{ $post->id }}"
                            data-model="post">
                    </td>

                    <td class="js-switch-{{ $post->id }} text-center">
                        <input type="checkbox" class="js-switch status" data-model="post" data-field="publish"
                            data-modelId="{{ $post->id }}" value="{{ $post->publish }}"
                            @checked($post->publish == 1) />
                    </td>

                    <td class="text-center">
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-success">
                            <i class="fa fa-edit"></i>
                        </a>
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
