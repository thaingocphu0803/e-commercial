(function ($) {
    "use strict";

    let FUNC = {};
    let prevCustomerType = [];
    let select2Placeholder = {
        vi: "click để chọn",
        en: "click to select",
        zh: "点击选择",
        ja: "クリックして選択",
    };
    let searchProductPlaceholder = {
        vi: "chọn sản phẩm...",
        en: "Select a product...",
        zh: "选择产品...",
        ja: "商品を選択...",
    };
    let currentPage;
    let timeoutId;
    let object =(typeof productChecked !== 'undefined') ? productChecked : [];

    let codeConflict = 0;
    let alertConflict = {
        1: {
            vi: "Vui lòng nhập giá trị 'Giá từ' nhỏ hơn 'Giá đến'.",
            en: "Please enter a 'Price From' value that is less than 'Price To'.",
            zh: "请输入小于'价格到'的'价格从'值。",
            ja: "「価格から」の値は「価格まで」の値より小さい値を入力してください。",
        },
        2: {
            vi: "Khoảng giá trị này đã tồn tại",
            en: "This price range already exists",
            zh: "该价格范围已存在",
            ja: "この価格帯はすでに存在します",
        },
        3: {
            en: "Conflict with other Range price",
            vi: "Khoảng giá này bị trùng với khoảng giá khác",
            zh: "该价格区间与其他区间冲突",
            ja: "この価格範囲は他の範囲と重複しています",
        },
    };
    let PriceValue = {
        vi: "₫",
        en: "$",
        zh: "€",
        ja: "¥",
    };
    let thead = {
        priceFrom: {
            vi: "Giá từ",
            en: "Price From",
            zh: "起始价格",
            ja: "価格（下限）",
        },
        priceTo: {
            vi: "Giá đến",
            en: "Price To",
            zh: "结束价格",
            ja: "価格（上限）",
        },
        discount: {
            vi: "Chiết khấu",
            en: "Discount",
            zh: "折扣",
            ja: "割引",
        },
        action: {
            vi: "Hành động",
            en: "Action",
            zh: "操作",
            ja: "操作",
        },
        product: {
            vi: "sản phẩm",
            en: "Product",
            zh: "产品",
            ja: "商品",
        },
        atLeast: {
            vi: "số lượng tối thiểu",
            en: "Minimum Quantity",
            zh: "最小数量",
            ja: "最小数量",
        },
        limit: {
            vi: "tối đa",
            en: "Maximum",
            zh: "最大值",
            ja: "最大値",
        },
    };
    let addBtn = {
        vi: "Thêm chiết khấu",
        en: "Add Discount",
        zh: "添加折扣",
        ja: "割引を追加",
    };

    let titleInStock = {
        vi: "Tồn kho",
        en: "In Stock",
        zh: "有库存",
        ja: "在庫あり",
    };

    let titleCanSell = {
        vi: "Có thể bán",
        en: "Can Sell",
        zh: "可售",
        ja: "販売可能",
    };

    let noImage = `https://res.cloudinary.com/my-could-api/image/upload/v1747992373/no-image_srgttq.svg`;

    FUNC.initDateTimePicker = () => {
        $(".datetimepicker").datetimepicker({
            timepicker: true,
            format: "Y-m-d H:i",
            // value: new Date(),
            minDate: new Date(),
            step: 30,
            onChangeDateTime: function (dp, $input) {
                FUNC.checkEndDate($input);
            },
        });
    };
    FUNC.enableNeverEndPromotion = () => {
        $(document).on("change", "#not_end_time", function (e) {
            e.preventDefault();
            let _this = $(this);
            if (_this.is(":checked")) {
                $('input[name="end_date"]').val("").prop("disabled", true);
            } else {
                let startDate = $('input[name="start_date"]').val();
                $('input[name="end_date"]')
                    .val(startDate)
                    .prop("disabled", false);
            }
        });
    };

    FUNC.checkEndDate = (input) => {
        let startDate = $('input[name="start_date"]').val();
        let endDate = $('input[name="end_date"]').val();
        if (startDate && endDate) {
            let start = new Date(startDate.replace(" ", "T"));
            let end = new Date(endDate.replace(" ", "T"));
            if (end < start) {
                $("#error_datetime_message").removeAttr("hidden");
                input.val("");
            } else {
                $("#error_datetime_message").attr("hidden", true);
            }
        }
    };

    FUNC.handleOpenSelectSource = () => {
        $(document).on("change", ".choose-source", function () {
            let _this = $(this);
            let parent = _this.parents(".col-lg-12");
            if (_this.is(":checked") && _this.attr("id") === "all_source") {
                parent.siblings(".multiple-select2").attr("hidden", true);
            } else if (
                _this.is(":checked") &&
                _this.attr("id") === "specific_source"
            ) {
                parent.siblings(".multiple-select2").removeAttr("hidden");
                $(".select2").select2({
                    placeholder: select2Placeholder[lang],
                });
            }
        });
    };

    FUNC.handleOpenSelectCustomer = () => {
        $(document).on("change", ".choose-customer", function () {
            let _this = $(this);
            let parent = _this.parents(".col-lg-12");
            if (_this.is(":checked") && _this.attr("id") === "all_customer") {
                parent.siblings(".multiple-select2").attr("hidden", true);
            } else if (
                _this.is(":checked") &&
                _this.attr("id") === "specific_customer"
            ) {
                parent.siblings(".multiple-select2").removeAttr("hidden");
                $(".select2").select2({
                    placeholder: select2Placeholder[lang],
                });
            }
        });
    };

    FUNC.handleChooseApplyCustomer = () => {
        $(document).on("change", "#customer_type", function () {
            let _this = $(this);
            let value = _this.val();

            if (prevCustomerType.length > value.length) {
                let removeId = prevCustomerType.filter((item) => {
                    return !value.includes(item);
                });
                let id = removeId[0];
                let button = $(`button[data-id='${id}']`);
                if (button.length) {
                    button.trigger("click");
                }
            }

            prevCustomerType = value;

            if (!Array.isArray(value)) return;

            value.forEach(async (val) => {
                await FUNC.HandleRenderCustomerType(val);
            });
        });
    };

    FUNC.HandleRenderCustomerType = async (value) => {
        let id = `customer_type_${value}`;
        let key = value;

        if ($(`#${id}`).length) return;

        let requestData = {
            type: key,
        };
        try {
            let response = await $.ajax({
                type: "GET",
                url: "/ajax/promotion/loadCustomerPromotionType",
                data: requestData,
                dataType: "json",
            });
            if (response.code !== 0) return;
            let data = response.data;
            let html = FUNC.renderSelectCustomerType(key, id, data);
            $(`.select-customer-type`).append(html);
            $(".select2").select2({ placeholder: select2Placeholder[lang] });
        } catch (err) {
            console.log(err);
        }
    };

    FUNC.removeSelectCustomerType = () => {
        $(document).on("click", ".remove-customer_type", function () {
            let _this = $(this);
            let parent = _this.parents(".col-lg-12");
            let id = _this.data("id");
            prevCustomerType = prevCustomerType.filter((item) => item !== id);
            $("#customer_type").val(prevCustomerType).trigger("change");
            parent.remove();
        });
    };

    FUNC.removeDiscountRow = () => {
        $(document).on("click", ".remove-discount-row", function (e) {
            e.preventDefault();
            let _this = $(this);
            let parent = _this.parents("tr");
            parent.remove();
        });
    };

    FUNC.coverPriceInput = () => {
        $(document).on("blur", ".priceInput", function () {
            let _this = $(this);
            let value = convertToCommas(_this.val());
            // Set the formatted value back to the input
            _this.val(value);
        });
    };

    FUNC.addDiscountRow = () => {
        let rowDiscount = FUNC.renderDiscountRow();
        $(document).on("click", ".add-discount-row", function (e) {
            e.preventDefault();
            $('.priceInput').trigger('change');

            if (codeConflict > 0) return;

            let table = $(".table-discount").find("tbody");
            table.append(rowDiscount);
        });
    };

    FUNC.checkRangePrice = () => {
        $(document).on("change", ".priceInput", function () {
            let _this = $(this);
            let thisRow = _this.parents("tr");

            let thisPriceFrom = thisRow
                .find('input[name="promotion[price_from][]"]')
                .val();
            let thisPriceTo = thisRow
                .find('input[name="promotion[price_to][]"]')
                .val();
            let priceFromArr = $('input[name="promotion[price_from][]"]')
                .map(function () {
                    return $(this).val();
                })
                .get();
            let priceToArr = $('input[name="promotion[price_to][]"]')
                .map(function () {
                    return $(this).val();
                })
                .get();

            let numDuplicate = 0;
            let isConflict = false;
            if (thisPriceFrom && thisPriceTo) {
                if (
                    convertToFloat(thisPriceFrom) >= convertToFloat(thisPriceTo)
                ) {
                    codeConflict = 1;
                    isConflict = true;
                }

                priceFromArr.forEach((priceFrom, index) => {
                    priceFrom = convertToFloat(priceFrom);
                    let priceTo = convertToFloat(priceToArr[index]);
                    thisPriceFrom = convertToFloat(thisPriceFrom);
                    thisPriceTo = convertToFloat(thisPriceTo);

                    // skipping this price in array
                    if (
                        thisPriceFrom === priceFrom &&
                        thisPriceTo === priceTo
                    ) {
                        numDuplicate += 1;
                    }

                    // check available range
                    else if (
                        (thisPriceFrom >= priceFrom &&
                            thisPriceFrom <= priceTo) ||
                        (thisPriceTo >= priceFrom && thisPriceTo <= priceTo) ||
                        (thisPriceFrom <= priceFrom && thisPriceTo >= priceTo)
                    ) {
                        codeConflict = 3;
                        isConflict = true;
                    }
                });

                if (parseInt(numDuplicate) > 1) {
                    codeConflict = 2;
                    isConflict = true;
                }

                if (isConflict) {
                    thisRow.find("input").addClass("border-red");
                    $("#error_range").text(alertConflict[codeConflict][lang]).removeClass('hidden');
                } else {
                    codeConflict = 0;
                    thisRow.find("input").removeClass("border-red");
                    $("#error_range").addClass('hidden');
                }
            }
        });
    };

    FUNC.selectTypePromotion = () => {
        $(document).on("change", "#method", function () {
            let _this = $(this);
            let table;
            switch (_this.val()) {
                case "order_total_discount":
                    table = FUNC.renderOrderTotalDiscount();
                    break;
                case "product_specific_discount":
                    table = FUNC.renderProductSpecificDiscount();
                    break;
                case "quantity_discount":
                    break;
                case "buy_x_get_discount_y":
                    break;
                default:
                    table = "";
            }

            $(".show-discount-table").html(table);
            if(object.length){
                $('.confirm-promotion-product-variant').trigger('click');
            }
        });
    };

    FUNC.RemoveTableDiscount = () => {
        $(".show-discount-table").html("");
    };

    FUNC.openProductPopup = () => {
        $(document).on("click", ".product-search", function () {
            let productType = $('select[name="module_type"]').val();

            switch (productType) {
                case "Product":
                    FUNC.ajaxLoadProduct();
                    break;
                case "productCatalouge":
                    FUNC.ajaxLoadProductCatalouge();
                    break;
                default:
                    break;
            }
        });
    };

    FUNC.handleSelectProductType = () => {
        $(document).on("change", "#module_type", function () {
            object = [];
            $(".choose-product-list").html("");
        });
    };

    FUNC.searchProductVariantEvent = () => {
        $(document).on("keyup", ".search-product-variant", function () {
            let _this = $(this);
            let val = _this.val();
            let requestData = {
                keyword: val,
            };

            clearTimeout(timeoutId);

            timeoutId = setTimeout(() => {
                if (val.length >= 2) {
                    FUNC.ajaxLoadProduct(requestData);
                }
            }, 1000);
        });
    };

    FUNC.paginationLinks = (links) => {
        let link = "";
        $.each(links, function (key, val) {
            let labelArr = val.label.split(" ");
            let isActive = val.active == true ? "active" : "";
            let isDisabled = !val.url ? "disabled" : "";
            let ariahidden = !val.url ? 'aria-hidden="true"' : "";
            let ariaDisable = !val.url ? 'aria-disabled="true"' : "";
            let ariaCurrent = val.active == true ? 'aria-current="page"' : "";

            if (labelArr.includes("Previous")) {
                link += `
                    <li
                        class="page-item ${isDisabled}"
                        ${ariaDisable}
                    >
                        <a
                            class="prodcut-variant-page-link"
                            ${ariahidden}
                            href="${val.url}"
                            aria-label="${val.label}"
                            ${val.url ? 'rel="prev"' : ""}
                        >
                            ‹
                        </a>
                    </li>
                `;
            } else if (labelArr.includes("Next")) {
                link += `
                    <li
                        class="page-item ${isDisabled}"
                        ${ariaDisable}

                    >
                        <a
                            class="prodcut-variant-page-link"
                            ${ariahidden}
                            href="${val.url}"
                            aria-label="${val.label}"
                            ${ariaDisable} ${val.url ? 'rel="next"' : ""}
                        >
                            ›
                        </a>
                    </li>
                `;
            } else {
                link += `
                    <li
                        class="page-item ${isActive}"
                         ${ariaCurrent}
                    >
                        <a class="prodcut-variant-page-link" href="${val.url}">${val.label}</a>
                    </li>
                `;
            }
        });

        let pagination = `
            <nav>
                <ul class="pagination">
                    ${link}
                </ul>
            </nav>
        `;
        return pagination;
    };

    FUNC.choosePaginateEvent = () => {
        $(document).on("click", ".prodcut-variant-page-link", function (e) {
            e.preventDefault();
            let _this = $(this);
            let parent = _this.closest(".page-item");
            let page = _this.text();
            let productType = $('select[name="module_type"]').val();

            if (_this.attr("rel") && _this.attr("rel") == "next") {
                currentPage = parent
                    .siblings(".active")
                    .find(".prodcut-variant-page-link")
                    .text();
                page = parseInt(currentPage) + 1;
            } else if (_this.attr("rel") && _this.attr("rel") == "prev") {
                currentPage = parent
                    .siblings(".active")
                    .find(".prodcut-variant-page-link")
                    .text();
                page = parseInt(currentPage) - 1;
            }

            let requestData = {
                page,
            };

            if (parent.hasClass("active") || parent.hasClass("disabled"))
                return;

            if (productType == "product_version") {
                FUNC.ajaxLoadProduct(requestData);
            } else if (productType == "product_catalouge") {
                FUNC.ajaxLoadProductCatalouge(requestData);
            }
        });
    };

    FUNC.ajaxLoadProduct = async (requestData) => {
        try {
            let response = await $.ajax({
                type: "GET",
                url: "/ajax/product/loadProductPromotion",
                data: requestData,
                dataType: "json",
            });
            if (response.code !== 0) return;
            let html = FUNC.renderProductVariantList(response.object.data);
            let pagination = FUNC.paginationLinks(response.object.links);
            $(".choose-product-list-body").html(html).append(pagination);
        } catch (err) {
            console.log(err);
        }
    };

    FUNC.ajaxLoadProductCatalouge = async (requestData) => {
        try {
            let response = await $.ajax({
                type: "GET",
                url: "/ajax/product/loadProductCatalougePromotion",
                data: requestData,
                dataType: "json",
            });
            if (response.code !== 0) return;
            let html = FUNC.renderProductCatalougeList(response.object.data);
            let pagination = FUNC.paginationLinks(response.object.links);
            $(".choose-product-list-body").html(html).append(pagination);
        } catch (err) {
            console.log(err);
        }
    };

    FUNC.renderSelectCustomerType = (key, id, data) => {
        //id: customer_type
        let options = data.map((item) => {

            return `<option value="${item.id}" ${
                promotionTypeData[id].includes(String(item.id))
                    ? "selected"
                    : ""
            }>${item.name}</option>`;
        });

        return `
        <div class="col-lg-12">
            <div class="form-row">
                <div class="flex flex-space-between mb-10">
                    <label for="${id}" class="control-label text-right text-capitalize">
                        ${customerKeyValue[key]}
                    </label>
                    <button type="button" class="btn btn-xs btn-danger remove-customer_type" data-id="${key}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                <select name="${id}[]" id="${id}"
                    class="form-control select2" multiple>
                    ${options}
                </select>
            </div>
        </div>
    `;
    };

    FUNC.renderProductVariantList = (data) => {
        let html = "";
        data.forEach((item) => {
            console.log(data);
            let productid = item.id;
            let variantid = item.variant_uuid;
            let image = item.image ? atob(item.image) : noImage;
            let name = item.product_name;
            let sku = item.sku;
            let price = item.price ? convertToCommas(item.price) : 0;
            let inStock = item.inStock ? convertToCommas(item.inStock) : 0;
            let canSell = item.canSell ? convertToCommas(item.canSell) : 0;
            let match = object.find((item) => item.productName === name);

            html += `
                <div class="promotion-product-variant-item col-lg-12 flex flex-space-between flex-middle border-b" data-productid="${productid}" data-variantid="${variantid}">
                    <div class="flex gap-20 flex-middle">
                        <input class="check-table" type="checkbox" name="product_checked[id][]"
                            value="" id="" ${match ? "checked" : ""}>
                        <div class="product-list-img">
                            <img class="img-cover"
                                src="${image}"
                                alt="">
                        </div>
                        <div>
                            <h3 class="text-bold promotion-product-variant-title">${name}</h3>
                            <span class="text-sm text-semibold text-blue-700 pointer">SKU:
                                ${sku}</span>
                        </div>
                    </div>
                    <div class="flex flex-col flex-center flex-align-end">
                        <h1 class="text-blod">${price} ${PriceValue[lang]}</h1>
                        <div class="flex flex-middle">
                            <span class="text-sm text-semibold px-5 border-r">${
                                titleInStock[lang]
                            }:
                                <span class="text-blue-700 pointer">${inStock}</span></span>
                            <span class="text-sm text-semibold px-5">${
                                titleCanSell[lang]
                            }: <span
                                    class="text-blue-700 pointer">${canSell}</span></span>
                        </div>
                    </div>
                </div>
            `;
        });

        return html;
    };

    FUNC.renderProductCatalougeList = (data) => {
        let html = "";
        data.forEach((item) => {
            let productCatalougeId = item.product_catalouge_id;
            let name = item.name;
            let match = object.find((item) => item.productName === name);

            html += `
                <div class="promotion-product-catalouge-item col-lg-12 flex flex-col gap-10" data-catalougeid="${productCatalougeId}">
                    <div class="flex gap-20 flex-middle">
                        <input class="check-table" type="checkbox" name="product_checked[id][]"
                            value="${productCatalougeId}" id="" ${match ? "checked" : ""}>
                        <div>
                            <h3 class="text-bold promotion-product-catalouge-title">${name}</h3>
                        </div>
                    </div>
                </div>
            `;
        });

        return html;
    };

    FUNC.choosePromotionProductVariantItem = () => {
        $(document).on("click", ".promotion-product-variant-item", function () {
            let _this = $(this);
            let checkbox = _this.find('input[type="checkbox"]');
            let isChecked = checkbox.prop("checked");
            let itemObject = {
                productId: _this.data("productid"),
                variantId: _this.data("variantid"),
                productName: _this
                    .find(".promotion-product-variant-title")
                    .text(),
            };
            if (isChecked) {
                object = object.filter(
                    (item) => item.productName != itemObject.productName
                );
                checkbox.prop("checked", false);
            } else {
                object.push(itemObject);
                checkbox.prop("checked", true);
            }
        });
    };

    FUNC.choosePromotionProductCatalougeItem = () => {
        $(document).on(
            "click",
            ".promotion-product-catalouge-item",
            function () {
                let _this = $(this);
                let checkbox = _this.find('input[type="checkbox"]');
                let isChecked = checkbox.prop("checked");
                let itemObject = {
                    productId: _this.data("catalougeid"),
                    variantId: null,
                    productName: _this
                        .find(".promotion-product-catalouge-title")
                        .text(),
                };
                if (isChecked) {
                    object = object.filter(
                        (item) => item.productName != itemObject.productName
                    );
                    checkbox.prop("checked", false);
                } else {
                    object.push(itemObject);
                    checkbox.prop("checked", true);
                }
            }
        );
    };

    FUNC.removeChoosedProductItem = () => {
        $(document).on("click", ".product-item-remove", function () {
            let _this = $(this);
            let parent = _this.parent(".choose-product-item");
            let productName = parent.find(".product-item-text").text();
            object = object.filter((item) => item.productName != productName);
            parent.remove();
        });
    };

    FUNC.saveOldCustomerType = () => {
        if (typeof selectedCustomerType !== 'undefined') {
            $("#customer_type").trigger("change");
        }
    };

    FUNC.saveOldTypePromotion = () => {
        $("#method").trigger("change");
    };

    FUNC.confirmPromotionProductVariant = () => {
        $(document).on(
            "click",
            ".confirm-promotion-product-variant",
            function () {
                let html = "";
                object.forEach((item) => {
                    html += `
                    <div class="choose-product-item flex flex-space-between flex-middle gap-10">
                        <span class="product-item-text">${item.productName}</span>
                        <span class="product-item-remove pointer"><i class="fa fa-times fa-lg" aria-hidden="true"></i></span>
                        <input type="hidden" name="product_checked[name][]" value="${item.productName}">
                        <input type="hidden" name="product_checked[variant][]" value="${item.variantId}">
                        <input type="hidden" name="product_checked[id][]" value="${item.productId}">
                    </div>
                `;
                });
                $(".choose-product-list").html(html).removeClass("hidden");
            }
        );
    };

    FUNC.renderDiscountRow = () => {
        return `
        <tr>
            <td>
                <input type="text" class="form-control text-center priceInput" name="promotion[price_from][]" value="0"/>
            </td>
            <td>
                <input type="text" class="form-control text-center priceInput" name="promotion[price_to][]" value="0"/>
            </td>
            <td class="flex flex-space-between">
                <input type="text" class="form-control text-center priceInput" name="promotion[discount][]" value="0"/>
                <select name="promotion[discount_type][]" style="border: 1px solid #e5e6e7">
                    <option value="percent">%</option>
                    <option value="amount">${PriceValue[lang]}</option>
                </select>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger remove-discount-row">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    };

    FUNC.renderOrderTotalDiscount = () => {
        let trTable = "";
        if (oldPriceFrom.length) {
            oldPriceFrom.forEach((value, index) => {
                let priceFrom = convertToCommas(value);
                let priceTo = convertToCommas(oldPriceTo[index]);
                let discount = convertToCommas(oldDiscount[index]);
                let discountType = oldDiscountType[index];

                trTable += `
                    <tr>
                        <td>
                            <input class="form-control text-center priceInput" type="text" name="promotion[price_from][]" value="${priceFrom}">
                        </td>
                        <td>
                            <input class="form-control text-center priceInput" type="text" name="promotion[price_to][]" value="${priceTo}">
                        </td>
                        <td class="flex flex-space-between">
                            <input class="form-control text-center priceInput" type="text" name="promotion[discount][]" value="${discount}">
                            <select name="promotion[discount_type][]" style="border: 1px solid #e5e6e7">
                                <option value="percent" ${discountType == "percent" ? 'selected' : ''}>%</option>
                                <option value="amount" ${discountType == "amount" ? 'selected' : ''}>${PriceValue[lang]}</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger remove-discount-row">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        } else {
            trTable = `
                <tr>
                    <td>
                        <input class="form-control text-center priceInput" type="text" name="promotion[price_from][]" value="0">
                       </td>
                    <td>
                        <input class="form-control text-center priceInput" type="text" name="promotion[price_to][]" value="0">
                    </td>
                    <td class="flex flex-space-between">
                        <input class="form-control text-center priceInput" type="text" name="promotion[discount][]" value="0">
                        <select name="promotion[discount_type][]" style="border: 1px solid #e5e6e7">
                            <option value="percent">%</option>
                            <option value="amount">${PriceValue[lang]}</option>
                           </select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger remove-discount-row">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
        return `
            <table class="table table-bordered table-hover table-discount">
                <thead>
                    <th class="text-center text-capitalize">${thead.priceFrom[lang]}</th>
                    <th class="text-center text-capitalize">${thead.priceTo[lang]}</th>
                    <th class="text-center text-capitalize">${thead.discount[lang]}</th>
                    <th class="text-center text-capitalize">${thead.action[lang]}</th>
                </thead>
                <tbody>
                    ${trTable}
                </tbody>
            </table>
            <p id="error_range" class="error-message hidden"></p>
            <button class="btn btn-success mt-10 add-discount-row">${addBtn[lang]}</button>
        `;
    };

    FUNC.renderProductSpecificDiscount = () => {
        let option = "";
        $.each(productTypes, (key, val) => {
            option += `<option value="${key}" ${oldProductType == key ? 'selected' : '' }>${val}</option>`;
        });
        return `
            <div class="col-lg-12 mb-20">
                <label for="module_type"
                    class="control-label text-right text-capitalize">product type</label>
                <select name="module_type" class="form-control select2" id="module_type">
                    ${option}
                </select>
            </div>
            <table class="table table-bordered table-hover table-discount">
                <thead>
                    <th class="text-center text-capitalize">${thead.product[lang]}</th>
                    <th class="text-center text-capitalize">${thead.atLeast[lang]}</th>
                    <th class="text-center text-capitalize">${thead.limit[lang]} (${PriceValue[lang]})</th>
                    <th class="text-center text-capitalize">${thead.discount[lang]}</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-lg-6">
                            <div class="product-search" data-toggle="modal"
                                        data-target="#searchProduct">
                                <div class="flex gap-10 justify-content-center form-control">
                                    <span><i class="fa fa-search" aria-hidden="true"></i></span>
                                    <span>${searchProductPlaceholder[lang]}</span>
                                </div>
                            </div>
                            <div class="choose-product-list mt-10 grid-2-col hidden">
                            </div>
                        </td>
                        <td>
                            <input class="form-control text-center" type="text"
                                name="product[min]" value="${oldProductMin}">
                        </td>
                        <td class="text-center">
                            <input class="form-control text-center" type="text"
                                name="product[max]" value="${oldProductMax}">

                        </td>
                        <td class="flex flex-space-between">
                            <input class="form-control text-center" type="text"
                                name="product[discount]" value="${oldProductDiscount}">
                            <select name="product[discount_type]"
                                style="border: 1px solid #e5e6e7">
                                <option value="percent" ${oldProductDiscounttype == "percent" ? 'selected' : '' }>%</option>
                                <option value="amount" ${oldProductDiscounttype == "amount" ? 'selected' : '' }>${PriceValue[lang]}</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        `;
    };

    $(document).ready(function () {
        FUNC.initDateTimePicker();
        FUNC.enableNeverEndPromotion();
        FUNC.checkEndDate();
        FUNC.handleOpenSelectSource();
        FUNC.handleOpenSelectCustomer();
        FUNC.handleChooseApplyCustomer();
        FUNC.removeSelectCustomerType();
        FUNC.addDiscountRow();
        FUNC.removeDiscountRow();
        FUNC.coverPriceInput();
        FUNC.checkRangePrice();
        FUNC.selectTypePromotion();
        FUNC.openProductPopup();
        FUNC.choosePaginateEvent();
        FUNC.searchProductVariantEvent();
        FUNC.choosePromotionProductVariantItem();
        FUNC.confirmPromotionProductVariant();
        FUNC.removeChoosedProductItem();
        FUNC.choosePromotionProductCatalougeItem();
        FUNC.handleSelectProductType();
        FUNC.saveOldCustomerType();
        FUNC.saveOldTypePromotion();
    });
})(jQuery);

const convertToFloat = (value) => {
    const strValue = String(value);
    const rawValue = strValue.replace(/,/g, "");
    const num = parseFloat(rawValue);
    return num;
};

const convertToCommas = (value) => {
    let StrValue = String(value);
    let num = StrValue.replace(/[^0-9.]/g, "");
    // Ensure only one decimal point is allowed
    const parts = num.split(".");
    if (parts.length > 2) {
        num = parts[0] + "." + parts.slice(1).join("");
    }
    // Format the num with commas as thousand separators
    num = num.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num;
};
