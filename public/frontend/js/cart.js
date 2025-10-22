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
            console.log(result);
            let totalQty = result.object.totalQty;

            FUNC.updateCartCount(totalQty);
        });
    };

    FUNC.handleUpdateCartItem = () => {
        $(document).on("input", "#cart_product_quantity", async function () {
            let _this = $(this);
            let parent = _this.parents(".cart-item");
            let cartItemId = parent.attr("data-cart-id");

            let qty = _this.val().replace(/[^0-9]/g, "");
            if (parseInt(qty) > 1000) {
                qty = 1000;
            } else if (parseInt(qty) < 1) {
                qty = 1;
            }

            _this.val(qty);

            let payload = {
                rowId: cartItemId,
                qty,
                _token,
            };

            let result = await $.ajax({
                type: "POST",
                url: "ajax/cart/update",
                data: payload,
                dataType: "json",
            });

            if (result.status === "ng") return;
            let discountCartTotal = result.object.discountCartTotal;
            let newCartItem = result.object.newCartItem;
            let totalDiscount = result.object.totalDiscount + discountCartTotal;
            let totalGrand = result.object.totalGrand - discountCartTotal;
            let totalQty = result.object.totalQty;
            let price = parseInt(newCartItem.price) * parseInt(newCartItem.qty);

            if (typeof newCartItem.options.old_price !== "undefined") {
                let oldPrice =
                    parseInt(newCartItem.options.old_price) *
                    parseInt(newCartItem.qty);
                parent.find(".cart-item-old-price").text(priceFormat(oldPrice));
            }

            parent.find(".cart-item-price").text(priceFormat(price));
            $(".cart-total .total-discount .value").text(`-${priceFormat(totalDiscount)}`);
            $(".cart-total .total-grand .value").text(`${priceFormat(totalGrand)}`);
            FUNC.updateCartCount(totalQty);
        });
    };

    FUNC.handleDeleteCartItem = () => {
        $(document).on("click", ".cart-item-trash", async function () {
            let _this = $(this);
            let parent = _this.parents(".cart-item");
            let cartItemId = parent.attr("data-cart-id");

            let payload = {
                rowId: cartItemId,
                _token,
            };

            let result = await $.ajax({
                type: "POST",
                url: "ajax/cart/delete",
                data: payload,
                dataType: "json",
            });

            if (result.status === "ng") return;
            parent.remove();
            toastr.clear();
            toastr.success(result.message, toastTitle[lang]);
            let discountCartTotal = result.object.discountCartTotal;
            let totalDiscount = result.object.totalDiscount + discountCartTotal;
            let totalGrand = result.object.totalGrand - discountCartTotal;
            let totalQty = result.object.totalQty;
            FUNC.updateCartCount(totalQty);

            // handle cart UI
            if(totalQty == 0){
                $('.cart-total').addClass('hidden');
                $('.cart-empty-message').removeClass('hidden');
                return;
            }

            // caculate total cart information
            $(".cart-total .total-discount .value").text(`-${priceFormat(totalDiscount)}`);
            $(".cart-total .total-grand .value").text(`${priceFormat(totalGrand)}`);
        });
    };

    FUNC.updateCartCount = (qty) => {
        $(".header-action-icon-2 .mini-cart-icon .pro-count").text(qty);
    };

    FUNC.updateCartCount = (qty) => {
        $('.header-action-icon-2 .mini-cart-icon .pro-count').text(qty);
    };

    $(document).ready(() => {
        FUNC.addCart();
        FUNC.handleUpdateCartItem();
        FUNC.handleDeleteCartItem();
    });
})(jQuery);
