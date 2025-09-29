(function($){
'use strict'

var FUNC = {};
var _token = $('meta[name="csrf-token"]').attr("content");

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

FUNC.handleRenderProductInModal = () => {
    $('.add-cart').on('click', async function(){
        let _this = $(this);
        let parent = _this.parents('.product-cart-wrap')
        let productId = parent.data("product-id");
        let productPromotionId = parent.data("product-promotion-id");
        let productUuid= parent.data("product-uuid");

        let payload = {
            product_id: productId,
            promotion_id: productPromotionId,
            uuid: productUuid,
            _token
        }

        const result = await $.ajax({
            type: "GET",
            url: "/ajax/product/loadProductWithVariant",
            data: payload,
            dataType: "json",
        });

        if(result.status == 'ng') return;

        let product = result.object;

        console.log(product);

        handleAppendName(product.name);
        handleAppendCatalouge(product.catalouges);
        handleAppendPrice(product.discounted_price, product.price);
        handleAppendDesc(product.description);
        handleAppendVariant(product.attrCatalouges, product.variant_codes);
        handleProductImage(product.image, product.album);
    })
}

$(document).ready(()=> {
    FUNC.handleProductAmount();
    FUNC.handleProductImage();
    FUNC.handleRenderProductInModal();
})
}(jQuery))

const handleAppendCatalouge = (catalouges) => {
    let catalougeList = $('.modal-product-catalouge .catalouge-list');
    let catalouge;
    catalougeList.html('');

    catalouges.forEach(catalouge => {
        let href = catalouge.product_catalouge_canonical;
        let catalougeId = catalouge.product_catalouge_id;

        catalouge = $('<a>')
                        .attr('href', href)
                        .attr('data-catalouge-id', catalougeId)
                        .addClass('list-item')
                        .text(catalouge.product_catalouge_name);

        catalougeList.append(catalouge);
    });
}

const handleAppendName = (name) => {
    $('.modal-product-title .title').text(name);
}

const handleAppendPrice = (discountedPrice, originalPrice) => {
        let priceMain = $('<span>').addClass('fs-3 text-infor');
        let priceOld = $('<span>').addClass('old-price text-danger ms-1 fs-6');

        if(discountedPrice){
            priceMain.text(discountedPrice);
            priceOld.text(originalPrice);
        }else{
            priceMain.text(originalPrice);
            priceOld.text('');
        }

        $('.modal-product-price').html('').append(priceMain, priceOld);
}

const handleAppendDesc = (desc) => {
    $('.modal-product-description .description-content').html(desc);
}

const handleAppendVariant = (attrCatalouges, codes) => {

    let productVariantBox =  $('.modal-product-variant-box');

    if(typeof attrCatalouges == 'undefined'){
        return productVariantBox.addClass('d-none').empty();
    };

    productVariantBox.removeClass('d-none').empty();

    attrCatalouges.forEach(catalouge => {
            let attCatalougue = $('<div>')
                        .addClass('modal-product-variant d-flex flex-column justify-items-center mt-5')
                        .attr('data-attr-catalouge-id', catalouge.attr_catalouge_id);

            let attrCatalougeTitle = $('<span>').addClass('fs-6 text-secondary text-capitalize').text(catalouge.attr_catalouge_name);

            let attrList = $('<div>').addClass('variant-list d-flex justify-content-strench gap-3');

            catalouge.attrs.forEach(attr => {
                let attrItem = $('<span>')
                            .addClass('list-item')
                            .attr('data-attr-id', attr.id)
                            .text(attr.name)
                if(codes.includes(`${attr.id}`)){

                    attrItem.addClass('active');
                }

                attrList.append(attrItem);

            })

            attCatalougue.append(attrCatalougeTitle);

            attCatalougue.append(attrList);

            productVariantBox.append(attCatalougue);
    });

}

const handleProductImage = (image, album) => {

    let decodeImg = atob(image);
    let srcImg = image ? decodeImg : noImage;

    // if(image){
    //     album.unshift(decodeImg);
    // }
    let img = $('<img>').addClass('img-cover').attr('src', srcImg);
    $(".modal-product-image .image-main").html(img);

    // if(album.lenght){
    //     album.forEach(img)
    // }

}
