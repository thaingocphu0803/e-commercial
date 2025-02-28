@props([
    'icon' => null,
    'title' => null,
])

<li class="active">
    <a href="index.html">
        <i class="fa {{$icon}} fa-lg"></i>
        <span class="nav-label text-capitalize">{{$title}}</span>
        <span class="fa arrow"></span>
        </a>
    <ul class="nav nav-second-level">
       {{$slot}}
    </ul>
</li>
