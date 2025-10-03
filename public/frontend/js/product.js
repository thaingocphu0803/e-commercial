(function ($) {
    "use strict";

    var FUNC = {};
    var _token = $('meta[name="csrf-token"]').attr("content");
    var productModalCache = {};
    var VariantModalCache = {};

    FUNC.handleProductAmount = () => {
        const [min, max] = [1, 1000];
        $(document).on("click", ".btn-hande-amount", function () {
            let _this = $(this);
            let input = _this.siblings('[name="product_amount"]');
            let amount = parseInt(input.val());

            if (_this.is("#btn_increase")) {
                amount += 1;
            } else if (_this.is("#btn_decrease")) {
                amount -= 1;
            }

            if (amount > max) {
                amount = max;
            } else if (amount < min) {
                amount = min;
            }

            input.val(amount);
        });
    };

    FUNC.handleProductImage = () => {
        $(document).on("click", ".image-list .list-item", function () {
            let _this = $(this);
            let src = _this.find("img").attr("src");
            let parent = _this.parents(".image-list");
            let sibling = parent.siblings(".image-main");

            sibling.find("img").attr("src", src);

            _this.addClass("active");
            _this.siblings().removeClass("active");
        });
    };

    FUNC.handleRenderProductInModal = () => {
        $(document).on("click", ".add-cart", async function () {
            let _this = $(this);
            let parent = _this.parents(".product-cart-wrap");
            let productId = parent.data("product-id");
            let productPromotionId = parent.data("product-promotion-id");
            let productUuid = parent.data("product-uuid");

            let payload = {
                product_id: productId,
                promotion_id: productPromotionId,
                uuid: productUuid,
                _token,
            };

            if (!productModalCache[productId]) {
                const result = await $.ajax({
                    type: "GET",
                    url: "/ajax/product/loadProductWithVariant",
                    data: payload,
                    dataType: "json",
                });

                if (result.status == "ng") return;
                productModalCache[productId] = result.object;
            }

            let product = productModalCache[productId];

            $("#open_product_modal").attr("data-model-product-id", product.id);

            handleAppendName(product.name);
            handleAppendCatalouge(product.catalouges);
            handleAppendPrice(product.discounted_price, product.price);
            handleAppendDesc(product.description);
            handleAppendVariant(
                product.attrCatalouges,
                product.variant_codes,
                product.attrs
            );
            handleProductImage(product.image, product.album);
        });
    };

    FUNC.handleRenderProductByVariant = () => {
        $(document).on(
            "click",
            ".modal-product-variant .variant-list .list-item",
            async function () {
                let _this = $(this);

                _this.addClass("active");

                _this.siblings(".list-item").removeClass("active");

                let attrCatalouge = $(".modal-product-variant");

                let attrArray = $(".modal-product-variant")
                    .map(function () {
                        return $(this)
                            .find(".variant-list .list-item.active")
                            .attr("data-attr-id");
                    })
                    .get()
                    .sort();

                if (attrCatalouge.length !== attrArray.length) return;

                let productId = $(".data-product-id").attr(
                    "data-model-product-id"
                );
                let code = attrArray.join("-");

                let payload = {
                    product_id: productId,
                    code,
                    _token,
                };

                let productCombineCode = `${productId}:${code}`;

                if (!VariantModalCache[productCombineCode]) {
                    const result = await $.ajax({
                        type: "GET",
                        url: "/ajax/product/loadProductByVariant",
                        data: payload,
                        dataType: "json",
                    });

                    if (result.status == "ng") return;

                    VariantModalCache[productCombineCode] = result.object;
                }

                let product = VariantModalCache[productCombineCode];

                handleAppendPrice(product.discounted_price, product.price);

                // handleProductImage(product.image, product.album);
            }
        );
    };

    FUNC.handleProductRedirect = () => {
        $(document).on("click", ".link-to-product", function (e) {
            e.preventDefault();
            let _this = $(this);

            let route = _this.attr("href");
            let parent = _this.parents(".product-cart-wrap");
            let productPromotionId = parent.data("product-promotion-id");
            let productUuid = parent.data("product-uuid");

            let payload = {
                promotion_id: productPromotionId,
                uuid: productUuid,
                _token,
            };

            let query = new URLSearchParams(payload).toString();

            window.location.href = route + "?" + query;
        });
    };

    $(document).ready(() => {
        FUNC.handleProductAmount();
        FUNC.handleProductImage();
        FUNC.handleRenderProductInModal();
        FUNC.handleRenderProductByVariant();
        FUNC.handleProductRedirect();

    });
})(jQuery);

const handleAppendCatalouge = (catalouges) => {
    let catalougeList = $(".modal-product-catalouge .catalouge-list");
    let catalouge;
    catalougeList.html("");

    catalouges.forEach((catalouge) => {
        let href = catalouge.product_catalouge_canonical;
        let catalougeId = catalouge.product_catalouge_id;

        catalouge = $("<a>")
            .attr("href", writeUrl(href, true, true))
            .attr("data-catalouge-id", catalougeId)
            .addClass("list-item")
            .text(catalouge.product_catalouge_name);

        catalougeList.append(catalouge);
    });
};

const handleAppendName = (name) => {
    $(".modal-product-title .title").text(name);
};

const handleAppendPrice = (discountedPrice, originalPrice) => {
    let priceMain = $("<span>").addClass("fs-3 text-infor");
    let priceOld = $("<span>").addClass("old-price text-danger ms-1 fs-6");

    if (discountedPrice) {
        priceMain.text(priceFormat(discountedPrice));
        priceOld.text(priceFormat(originalPrice));
    } else {
        priceMain.text(priceFormat(originalPrice));
        priceOld.text("");
    }

    $(".modal-product-price").html("").append(priceMain, priceOld);
};

const handleAppendDesc = (desc) => {
    $(".modal-product-description .description-content").html(desc);
};

const handleAppendVariant = (attrCatalouges, codes, attrs) => {
    let productVariantBox = $(".modal-product-variant-box");

    if (typeof attrCatalouges == "undefined") {
        return productVariantBox.addClass("d-none").empty();
    }

    productVariantBox.removeClass("d-none").empty();

    attrCatalouges.forEach((catalouge) => {
        let attCatalougue = $("<div>")
            .addClass(
                "modal-product-variant d-flex flex-column justify-items-center mt-5"
            )
            .attr("data-attr-catalouge-id", catalouge.attr_catalouge_id);

        let attrCatalougeTitle = $("<span>")
            .addClass("fs-6 text-secondary text-capitalize")
            .text(catalouge.attr_catalouge_name);

        let attrList = $("<div>").addClass(
            "variant-list d-flex justify-content-strench gap-3"
        );

        catalouge.attrs.forEach((attr) => {
            if (attrs.includes(attr.id)) {
                let attrItem = $("<span>")
                    .addClass("list-item")
                    .attr("data-attr-id", attr.id)
                    .text(attr.name);

                if (codes.includes(`${attr.id}`)) {
                    attrItem.addClass("active");
                }

                attrList.append(attrItem);
            }
        });

        attCatalougue.append(attrCatalougeTitle);

        attCatalougue.append(attrList);

        productVariantBox.append(attCatalougue);
    });
};

const handleProductImage = (image, album) => {
    let srcImg = image ? atob(image) : noImage;
    let imgList = $(".modal-product-image .image-list");

    let mainImg = $("<img>").addClass("img-cover").attr("src", srcImg);
    $(".modal-product-image .image-main").html(mainImg);

    imgList.empty();

    if (image) {
        let mainItem = $("<div>")
            .addClass("list-item active")
            .append($("<img>").addClass("img-cover").attr("src", srcImg));
        imgList.append(mainItem);
    }

    if (album && album.length) {
        album.forEach((src) => {
            let item = $("<div>")
                .addClass("list-item")
                .append($("<img>").addClass("img-cover").attr("src", src));
            imgList.append(item);
        });
    }
};
