@props([
    'categories' => [],
])
<section class="popular-categories section-padding">
    <div class="container wow animate__ animate__fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
        <div class="section-title">
            <div class="title">
                <h3>{{ __('custom.productCategory') }}</h3>
            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carousel-10-columns-arrow" id="carousel-10-columns-arrows">
            </div>
        </div>
        <div class="carousel-10-columns-cover position-relative">
            <div class="carousel-slider-wrapper carousel-10-columns" id="carousel-10-columns" title="Danh mục nổi bật"
                data-slick='{"autoplay":false,"infinite":false,"autoplaySpeed":3000,"speed":800}' data-items-xxl="10"
                data-items-xl="6" data-items-lg="4" data-items-md="3" data-items-sm="2">
                @foreach ($categories as $category)
                    <div class="card-2 wow animate__ animate__fadeInUp" data-wow-delay="0.1s">
                        <figure class="img-hover-scale overflow-hidden">
                            <a href="{{write_url($category->canonical, true, true)}}">
                                <img src="{{!empty($category->image) ? base64_decode($category->image) : config('app.general.noImage')}}"
                                    alt="{{$category->name}}">
                            </a>
                        </figure>
                        <p class="heading-card">
                            <a href="{{write_url($category->canonical, true, true)}}" title="{{$category->name}}">
                                {{$category->name}}
                            </a>
                        </p>
                        <span>{{$category->product_quantity. " ". __('custom.product')}}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
