<ol class="dd-list">
    @foreach ( $trees as  $tree )
        <li class="dd-item" data-id="{{ $tree->id }}">
            <div class="dd-handle">
                <span class="label label-info"><i class="fa fa-arrows"></i></span>
                <span>{{ $tree->menuLanguage->name }}</span>
            </div>
            <a href="{{route('menu.child.index', $tree->id)}}" class="to-child-menu">{{__('custom.manageChildMenu')}}</a>

            @if($tree->children->count() > 0)
                <x-backend.menu.menu.nestable :trees="$tree->children" />
            @endif
        </li>
    @endforeach
</ol>
