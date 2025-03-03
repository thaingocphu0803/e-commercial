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
                <th>{{__('table.name')}}</th>
                <th>{{__('table.numMember')}}</th>
                <th>{{__('table.description')}}</th>
                <th>{{__('table.active')}}</th>
                <th>{{__('table.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userCatalouges as $userCatalouge)
                <tr>
                    <td><input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $userCatalouge->id }}"></td>
                    <td class="text-capitalize">{{ $userCatalouge->name }}</td>
                    <td class="text-capitalize">{{ $userCatalouge->users_count }}</td>
                    <td>{{ $userCatalouge->description }}</td>
                    <td class="js-switch-{{ $userCatalouge->id }}">
                        <input type="checkbox" class="js-switch status" data-model="userCatalouge" data-field="publish"
                            data-modelId="{{ $userCatalouge->id }}" value="{{ $userCatalouge->publish }}"
                            @checked($userCatalouge->publish == 1) />
                    </td>
                    <td>
                        <a href="{{ route('user.catalouge.edit', $userCatalouge->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('user.catalouge.delete', $userCatalouge->id) }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $userCatalouges->links('pagination::bootstrap-4') }}

</div>
