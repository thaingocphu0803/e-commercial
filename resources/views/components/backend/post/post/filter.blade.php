<form action="{{ route('post.index') }}">
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
                            <option value={{ $i }} @selected($perpage == $i)> {{ $i }} records
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flex gap-10">
                    <select name="publish" class="form-control  select2">
                        <option value="0" selected> Choose Post Status</option>
                        <option value="1" @selected(request('publish') == 1)>Published</option>
                        <option value="2" @selected(request('publish') == 2)>Private</option>
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
            <a href="{{ route('post.create') }}" class="btn btn-danger"><i class="fa fa-plus"> Add Post</i></a>

        </div>
    </div>

</form>
