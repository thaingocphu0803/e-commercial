(function($){
'use strict'

var FUNC = {};

FUNC.handleProductAmount = () => {
    const [min, max] = [1,1000];
    $(document).on('click', '.btn-hande-amount', function(){
        let _this = $(this);
        let input = _this.siblings('[name="product_amount"]');
        let amount = parseInt(input.val());
        
        if(_this.is('#btn_increase')){
           amount += 1;
        }else if(_this.is('#btn_decrease')){
           amount -= 1;
        }

        if(amount > max){
            amount = max
        }else if(amount < min){
            amount = min
        }

        input.val(amount);
    })
}

FUNC.handleProductImage = () => {
    $(document).on('click', '.image-list .list-item', function(){
        let _this = $(this);
        let src = _this.find('img').attr('src');
        let parent = _this.parents('.image-list');
        let sibling = parent.siblings('.image-main');

        sibling.find('img').attr('src', src);

        _this.addClass('active');
        _this.siblings().removeClass('active')
    })
}

$(document).ready(()=> {
    FUNC.handleProductAmount();   
    FUNC.handleProductImage(); 
})  
}(jQuery))