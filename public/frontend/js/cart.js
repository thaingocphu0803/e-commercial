(function ($) {
    "use strict";

    var FUNC = {};
    var _token = $('meta[name="csrf-token"]').attr("content");
    var toastTitle = {
        vn: "Giỏ hàng!",
        en: "Shopping Cart!",
        ja: "ショッピングカート!",
        zh: "购物车!",
    };

    FUNC.addCart = () => {
        $(document).on("click", ".btn-addToCart", async function () {
            let _this = $(this);
            let parent = _this.parents(".product-infor");
            let quantity = parent.find('input[name="product_quantity"]').val();
            let productId = parent.attr("data-model-product-id");
            let productPromotionId = parent.attr("data-product-promotion-id");
            let productUuid = parent.attr("data-product-uuid");

            let payload = {
                product_id: productId,
                promotion_id: productPromotionId,
                uuid: productUuid,
                quantity,
                _token,
            };

            let result = await $.ajax({
                type: "POST",
                url: "ajax/cart/create",
                data: payload,
                dataType: "json",
            });

            if (result.status === "ng") return;
            toastr.clear();
            toastr.success(result.message, toastTitle[lang]);

            let total = caculate_total_quantity(result.object);
        });
    };

    FUNC.handleUpdateCartItem = () => {
        $(document).on("input", "#cart_product_quantity", async function () {
            let _this = $(this);
            let parent = _this.parents(".cart-item");
            let cartId = parent.attr('data-cart-id');

            let qty = _this.val().replace(/[^0-9]/g, "");
            if (parseInt(qty) > 1000) {
                qty = 1000;
            } else if (parseInt(qty) < 1) {
                qty = 1;
            }

            _this.val(qty);

            let payload = {
                rowId: cartId,
                qty,
                _token
            }

            let result = await $.ajax({
                type: "POST",
                url: "ajax/cart/update",
                data: payload,
                dataType: "json",
            });

            if (result.status === "ng") return;

            let newCartItem = result.object.newCartItem;
            let totalDiscount = result.object.totalDiscount;
            let totalGrand = result.object.totalGrand;
            let oldPrice = newCartItem.options.old_price * parseInt(newCartItem.qty);
            let price = (newCartItem.price) * parseInt(newCartItem.qty);
            
            parent.find('.cart-item-old-price').text(priceFormat(oldPrice));
            parent.find('.cart-item-price').text(priceFormat(price));
            $('.cart-total .total-discount .value').text(totalDiscount);
            $('.cart-total .total-grand .value').text(totalGrand);


        });
    };
    
    FUNC.handleDeleteCartItem = () => {
        $(document).on('click', '.cart-item-trash', function(){
            let _this =$(this);
            console.log(1);
        })
    }

    $(document).ready(() => {
        FUNC.addCart();
        FUNC.handleUpdateCartItem();
        FUNC.handleDeleteCartItem();
    });
})(jQuery);
