<div class="filter">
    <div class="flex flex-middle flex-space-between">
        <div class="perpage">
            <select name="perpage" class="form-control perpage filter mr-10">
                @for ($i = 20; $i <= 200; $i += 20)
                    <option id={{ $i }}> {{ $i }} records</option>
                @endfor
            </select>
        </div>

        <div class="action flex ">
            <div class="flex">
                <select name="user_catalouge_id" class="form-control mr-10">
                    <option value="0" disabled selected> Choose Group Member</option>
                    <option value="1">VIP Member</option>
                </select>
            </div>

            <div class="flex flex-middle mr-10">
                <div class="input-group">
                    <input class="form-control" type="text" name="keyword"
                        placeholder="Enter keyword...">

                    <span class="input-group-btn">
                        <button class="btn btn-primary search-btn" type="submit" name="search"
                            value="search">
                            Search
                        </button>
                    </span>
                </div>
            </div>

            <a href="{{route('user.create')}}" class="btn btn-danger"><i class="fa fa-plus"> Add Member</i></a>
        </div>
    </div>
</div>
