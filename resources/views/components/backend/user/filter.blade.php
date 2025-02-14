<form action="{{ route('user.index') }}">
    @csrf

    @php
        $perpage = request('perpage') ?? old('perpage');
    @endphp

    <div class="filter">
        <div class="flex flex-middle flex-space-between">

            <div class="action flex gap-10">
                <div class="perpage gap-10">
                    <select name="perpage" class="form-control perpage filter ">
                        @for ($i = 20; $i <= 200; $i += 20)
                            <option value={{ $i }} @selected($perpage == $i)> {{ $i }} records
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flex gap-10">
                    <select name="user_catalouge_id" class="form-control  select2">
                        <option disabled selected> Choose User Status</option>
                        <option value="1">Published</option>
                        <option value="0">Private</option>

                    </select>
                </div>

                <div class="flex gap-10">
                    <select name="user_catalouge_id" class="form-control  select2">
                        <option disabled selected> Choose Group Member</option>
                        <option value="1">VIP Member</option>
                    </select>
                </div>

                <div class="flex flex-middle gap-10">
                    <div class="input-group">
                        <input class="form-control" type="text" name="keyword"
                            value="{{ request('keyword') ?? old('keyword') }}" placeholder="Enter keyword...">

                        <span class="input-group-btn">
                            <button class="btn btn-primary search-btn" type="submit">
                                Search
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <a href="{{ route('user.create') }}" class="btn btn-danger"><i class="fa fa-plus"> Add Member</i></a>

        </div>
    </div>

</form>
