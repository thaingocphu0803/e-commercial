(function($){
    "use strict"

    var FUNC = {};

    FUNC.initSwipper  = () => {
        let settings = $('.pannel-slide-swipper');
        if(settings.length){
            let option = FUNC.getSwipperOption(settings.data("settings"));
            let swipper  = new Swiper('.pannel-slide-swipper', option);
        }
    }

    FUNC.getSwipperOption = (settings) => {
        let option = {};
        option.loop = true;
        option.slidesPerView = 1;

        if(settings.arrow === 'accept'){
            option.navigation = {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            };
        }

        if(settings.navigate === 'dots'){
            option.pagination = {
                el: '.swiper-pagination',
                clickable: true
            }
        }

        if(settings.navigate === 'dots'){
            option.pagination = {
                el: '.swiper-pagination',
                clickable: true
            }
        }

        if(settings.effect.length){
            option.effect = settings.effect;
            option.speed = parseInt(settings.speed_effect) || 500;
        }else{
            option.effect = "slide";
            option.speed = 500;
        }

        if(settings.autoplay === 'accept'){
            option.autoplay = {
                delay: parseInt(settings.duration_slide) || 3000,
                disableOnInteraction: false,
            }
        }

        return option;
    }

    $(document).ready(() =>  {
        FUNC.initSwipper();
    });
})(jQuery);
