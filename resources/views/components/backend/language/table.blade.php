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
                <th>Flag</th>
                <th>Canonical</th>
                <th>Description</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($languages as $language)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table" value="{{ $language->id }}">
                    </td>
                    <td class="text-capitalize">{{ $language->name }}</td>
                    <td>
                        @if (!empty($language->image))
                            <img src="{{ base64_decode($language->image) }}" alt="country's flag" class="table-img">
                        @endif
                    </td>
                    <td>{{ $language->canonical }}</td>
                    <td>{{ $language->description }}</td>
                    <td class="js-switch-{{ $language->id }}">
                        <input type="checkbox" class="js-switch status" data-model="language" data-field="publish"
                            data-modelId="{{ $language->id }}" value="{{ $language->publish }}"
                            @checked($language->publish == 1) />
                    </td>
                    <td>
                        <a href="{{ route('language.edit', $language->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('language.delete', $language->id) }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $languages->links('pagination::bootstrap-4') }}

</div>
