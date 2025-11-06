@props([
    'product_catalouge_id' => null,
    'product_catalouge_name' => null,
    'breadcrumbs' => []
])

<div class="page-breadcrumb">
    <h1 class="heading-2 text-capitalize mb-5">
        <span>{{ $product_catalouge_name }}</span>
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb d-flex align-items-center fs-6">
            <li class="breadcrumb-item">
                <a href="{{config('app.url')}}" class="text-capitalize">
                    <i class="fi-rs-home mr-5"></i>
                    {{__('custom.home')}}
                </a>
            </li>
            @foreach ( $breadcrumbs as  $breadcrumb)
                <li class="breadcrumb-item" >
                    <a href="{{write_url($breadcrumb->canonical, true ,true)}}" class="text-capitalize {{($product_catalouge_id == $breadcrumb->id) ? 'active' : ''}}">
                        {{$breadcrumb->name}}
                    </a>
                </li>
            @endforeach
        </ol>
    </nav>

</div>
