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

    FUNC.handleProductCategorySelect = () => {
        $(document).on('change', '.product-category-select', function(){
            let _this = $(this);
            let selectedName = _this.find('option:selected').text();
           
            $('.product-cat-label').text(selectedName);
        })
    }

    FUNC.handleDropdownAllCategories = () => {
        $(document).on('click', '.categories-button-active', function(){
            let _this = $(this);
            let dropdown = $('.categories-dropdown-wrap');
            let icon = _this.find('i')
            
            if(_this.hasClass('open')){
                _this.removeClass('open');
                icon.removeClass('fi-rs-angle-up').addClass('fi-rs-angle-down');          

            }else{
                _this.addClass('open');
                icon.removeClass('fi-rs-angle-down').addClass('fi-rs-angle-up');
            }

            
            if(dropdown.hasClass('open')){
                dropdown.removeClass('open');
            }else{
                dropdown.addClass('open');
            }

        })
    }

    $(document).ready(() =>  {
        FUNC.initSwipper();
        FUNC.handleProductCategorySelect();
        FUNC.handleDropdownAllCategories();
    });
})(jQuery);
