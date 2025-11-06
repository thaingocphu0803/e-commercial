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
                <th class="text-center w-80">{{ __('custom.order') }}</th>
                <th class="text-center">{{ __('custom.active') }}</th>
                <th class="text-center">{{ __('custom.action') }}</th>
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
                                    <span
                                        class="text-danger">{{ __('custom.objectGroup', ['attribute' => __('custom.catalouge')]) }}:</span>
                                    @foreach ($post->postCatalouges as $postCatalouge)
                                        <a href="#"
                                            title="">{{ $postCatalouge->languages->pluck('pivot.name')->implode(',') }}</a>
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

                        @can('modules', 'post.update')
                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan

                        @can('modules', 'post.delete')
                            <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endcan

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $posts->links('pagination::bootstrap-4') }}

</div>
