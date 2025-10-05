(function($){
'use strict'

var FUNC = {};
var _token = $('meta[name="csrf-token"]').attr("content");
var toastTitle = {
    vn: "Giỏ hàng!",
    en: "Shopping Cart!",
    ja: "ショッピングカート!",
    zh: "购物车!"
};



FUNC.addCart = () => {
    $(document).on('click', '.btn-addToCart', async function(){
        let _this = $(this);
        let parent = _this.parents('.product-infor')
        let quantity = parent.find('input[name="product_quantity"]').val();
        let productId = parent.attr('data-model-product-id');
        let productPromotionId = parent.attr('data-product-promotion-id');
        let productUuid = parent.attr('data-product-uuid');

        let payload = {
            product_id: productId,
            promotion_id: productPromotionId,
            uuid: productUuid,
            quantity,
            _token
        }

        let result = await $.ajax({
            type: "POST",
            url: "ajax/cart/create",
            data: payload,
            dataType: "json",
        });

        if(result.status === 'ng') return;
        toastr.clear();
        toastr.success(result.message, toastTitle[lang]);

        let total = caculate_total_quantity(result.object);


    })
}

$(document).ready(()=> {
    FUNC.addCart();
})

}(jQuery))
