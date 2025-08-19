@props([
    'banners' => [],
])

<section class="banners pt-60">
    <div class="container">
        <div class="row justify-content-center">
            @foreach ( $banners['image'] as $key => $val )

            <div class="col-lg-4 col-md-6">
                <div class="banner-img wow animate__ animate__fadeInUp  animated" data-wow-delay="0.2"
                    style="visibility: visible; animation-name: fadeInUp;">
                    <div class="page_speed_834922116">
                        <a
                            href="{{write_url($banners['url'][$key], true, true)}}"
                            target="{{$banners['newtab'][$key] ?? '_blank'}}" title="Banner">
                            <picture>
                                <source srcset="{{$banners['image'][$key] ?? config('app.general.noImage')}}"
                                    media="(min-width: 1200px)">
                                <source srcset="{{$banners['image'][$key] ?? config('app.general.noImage')}}"
                                    media="(min-width: 768px)">
                                <source srcset="{{$banners['image'][$key] ?? config('app.general.noImage')}}"
                                    media="(max-width: 767px)"><img
                                    src="{{$banners['image'][$key] ?? config('app.general.noImage')}}" data-bb-lazy="true"
                                    class="page_speed_717204954" loading="lazy" alt="{{$banners['alt'][$key] ?? ''}}">
                            </picture>
                        </a>
                    </div>
                    <div class="banner-text">
                        <h4 class="text-silver-300">{{$banners['desc'][$key] ?? ''}}</h4>
                        <a
                            href="{{write_url($banners['url'][$key], true, true)}}"
                            target="{{$banners['newtab'][$key] ?? '_blank'}}" class="btn btn-xs">{{__('custom.shopNow')}}<i class="fi-rs-arrow-small-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
