<form action="{{ route('permission.index') }}">
    @csrf

    @php
        $perpage = request('perpage') ?? old('perpage');
    @endphp

    <div class="filter">
        <div class="flex flex-middle flex-space-between">

            <div class="action flex gap-10">
                <div class="perpage gap-10">
                    <select name="perpage" class="form-control perpage filter ">
                        @for ($i = 10; $i <= 100; $i += 10)
                            <option value={{ $i }} @selected($perpage == $i)>
                                {{ $i . ' ' . __('table.records') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flex gap-10">
                    <select name="publish" class="form-control  select2">
                        <option value="0" selected>
                            {{ __('table.chooseObject', ['attribute' => __('table.languageStatus')]) }}
                        </option>
                        <option value="1" @selected(request('publish') == 1)>
                            {{ __('table.published') }}
                        </option>
                        <option value="2" @selected(request('publish') == 2)>
                            {{ __('table.private') }}
                        </option>
                    </select>
                </div>

                <div class="flex flex-middle gap-10">
                    <div class="input-group">
                        <input class="form-control" type="text" name="keyword"
                            value="{{ request('keyword') ?? old('keyword') }}"
                            placeholder="{{ __('table.searchBy', ['attribute' => __('table.name')]) }}...">

                        <span class="input-group-btn">
                            <button class="btn btn-primary search-btn" type="submit">
                                {{ __('table.search') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            @can('modules', 'permission.create')
                <a href="{{ route('permission.create') }}" class="btn btn-danger">
                    <i class="fa fa-plus">
                        {{ __('table.addObject', ['attribute' => __('dashboard.permission')]) }}
                    </i>
                </a>
            @endcan

        </div>
    </div>

</form>
