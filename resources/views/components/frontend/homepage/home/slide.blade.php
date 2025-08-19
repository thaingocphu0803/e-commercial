@props([
    'settings' => null,
    'slides' => [],
])

<section class="home-slider position-relative mb-30 mt-30">
    <div class="container">
        <div class="home-slide-cover mt-30">
            <div class="pannel-slide-swipper" data-settings="{{ $settings }}">
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    @foreach ($slides['image'] as $key => $val)
                        <div class="swiper-slide hero-slider-1">
                            <img class="slide-img" src="{{$slides['image'][$key] ?? config('app.general.noImage')}}" alt="">
                            <div class="slider-content">
                                <p class="display-2 mb-40">{{__('custom.sigupLetter')}}</p>
                                <div class="newsletter">
                                    <form method="POST" action="/newsletter/subscribe" class="newsletter-form">
                                        <div class="form-subscribe d-flex">
                                            <input class="form-control" placeholder="{{__('custom.enterEmail')}}" name="email"
                                                type="email" required>
                                            <button class="btn" type="submit">{{__('custom.register')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
</section>
