let variantAlbum = [];
let currentTitle = [];
let curentTypeVariant = [];
let prevAttrId = [];
let deletedId = null;
let ids = [];

// cloudinary upload variant Image
const variantImageUpload = cloudinary.createUploadWidget(
    {
        cloudName,
        uploadPreset,
        folder: "album/variant",
        multiple: true,
        transformation: [{ width, height, crop: "thumb" }],
        sources: ["local", "url", "image_search"],
        googleApiKey: "AIzaSyBMnZuJmBV2_6QHMYDOleTyxe67M6RplNg",
        searchBySites: ["all", "cloudinary.com"],
        searchByRights: true,
    },
    (error, result) => {
        if (!error && result && result.event === "success") {
            $("#sortable-variant").append(`
                <li class="ui-state-default">
                    <div class="thumb">
                        <span class="span image image-scaledown">
                            <img src="${result.info.url}" alt="${result.info.asset_folder} image">
                        </span>
                        <button type="button" class="delete-image">
                            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                        </button>
                    </div>
                </li>
            `);

            $(".click-to-upload-variant").addClass("hidden");
            $(".upload-list-variant").removeClass("hidden");

            variantAlbum.push(result.info.url);
        }
    }
);

$(document).on("click", ".upload-variant-picture", function (e) {
    e.preventDefault();
    variantImageUpload.open();
});

//delete variant picture
$(document).on("click", ".delete-image", function () {
    let _this = $(this);

    let item = _this.parents(".ui-state-default");
    let itemUrl = item.find("img[src]").attr("src");
    item.remove();

    variantAlbum = variantAlbum.filter((url) => {
        return url != itemUrl;
    });

    if ($(`.ui-state-default`).length == 0) {
        $(".click-to-upload-variant").removeClass("hidden");
        $(".upload-list-variant").addClass("hidden");
    }
});

$("#sortable-variant").sortable();

$("#sortable-variant").disableSelection();

//toggle variant checked
$("#variantCheckbox").on("change", function () {
    let message = {
        vi: "Bạn phải nhập giá tiền và barcode để mở.",
        en: "You must enter both price and barcode to open.",
        ja: "開くには、価格とバーコードの両方を入力する必要があります。",
        zh: "要打开，必须输入价格和条形码。",
    };

    let _this = $(this);
    let price = $('input[name="price"]').val();
    let code = $('input[name="code"]').val();

    if (price == "" || code == "") {
        alert(message[lang]);
        _this.prop("checked", false);
    }

    if (_this.is(":checked")) {
        $("#variant-wrapper").removeClass("hidden");
        $("#variant-setting").removeClass("hidden");
    } else {
        $("#variant-wrapper").addClass("hidden");
        $("#variant-setting").addClass("hidden");
    }
});

//add variant event
$(document).on("click", "#add-variant-btn", function () {
    const variantExisted = $(".variant-item");
    const variantItem = getVariantItem();

    if (variantExisted.length < listAttr.length) {
        $("#variant-body").append(variantItem);
    }

    $(".select2-play").select2();
});

// select attribute
$(document).on("change", ".choose-attribute", function () {
    let _this = $(this);
    let previousId = parseInt(_this.data("prev"));
    let currentId = parseInt(_this.val());
    let parent = _this.parents(".col-lg-3");

    let htmlSelect = ajaxSelectElement(currentId);

    if (previousId > 0 && previousId !== currentId) {
        ids = ids.filter((id) => id !== previousId);

        $(".choose-attribute")
            .find(`option[value="${previousId}"]`)
            .prop("disabled", false);
    }

    _this.data("prev", currentId);

    parent.siblings(".col-lg-8").html(htmlSelect);
    thisSelect = parent.find(".variant-select");

    $(".variant-select").each(function (key, index) {
        if (!$(this).hasClass("select2-hidden-accessible")) {
            initAjaxSelect($(this));
        }
    });

    if (!ids.includes(currentId)) {
        ids.push(currentId);
    }

    ids.forEach((id) => {
        $(".choose-attribute")
            .find(`option[value="${id}"]`)
            .prop("disabled", true);
    });
});

//init ajax Select
const initAjaxSelect = (object) => {
    const placeholder = {
        en: "Please enter at least 2 characters to searching",
        vi: "Vui lòng nhập ít nhất 2 ký tự để tìm kiếm",
        ja: "検索するには2文字以上入力してください。",
        zh: "请输入至少两个字符进行搜索。",
    };
    let option = {
        attrCatalougeId: object.data("catid"),
    };
    $(object).select2({
        minimumInputLength: 2,
        placeholder: placeholder[lang],
        ajax: {
            url: "/ajax/attr/getAttr",
            type: "GET",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    option: option,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj, i) {
                        return obj;
                    }),
                };
            },
            cache: true,
        },
    });
};

// remove attribute
$(document).on("click", ".remove-attribute", function () {
    let _this = $(this);
    let parent = _this.parents(".variant-item");

    let optionId = parent.find(`option:selected`).val();
    let optionContent = parent
        .find(`select[name="attr"] option:selected`)
        .text();
    optionContent = optionContent.replace("- ", "");

    $(".attr-catalogue-thead").each(function () {
        let _this = $(this);
        if (_this.text() == optionContent) {
            _this.remove();
        }
    });

    $(".attr-catalogue-td").each(function () {
        let _this = $(this);
        let dataAttrName = _this.data("attrname");
        let content = _this.text();

        currentTitle = currentTitle.filter((title) => title != dataAttrName);

        if (dataAttrName == optionContent) {
            _this.remove();
        }
        let variantAttrName = _this
            .siblings(".td-variant")
            .find('input[name="attr[name][]"]')
            .val();
        variantAttrName = String(variantAttrName).split("-");

        let variantAttrId = _this
            .siblings(".td-variant")
            .find('input[name="attr[id][]"]')
            .val();
        variantAttrId = String(variantAttrId).split("-");

        for (let i = 0; i < variantAttrName.length; i++) {
            if (variantAttrName[i] == content) {
                variantAttrName.splice(i, 1);
                variantAttrName = variantAttrName.join("-");
                _this
                    .siblings(".td-variant")
                    .find('input[name="attr[name][]"]')
                    .attr("value", variantAttrName);

                variantAttrId.splice(i, 1);
                variantAttrId = variantAttrId.join("-");
                _this
                    .siblings(".td-variant")
                    .find('input[name="attr[id][]"]')
                    .attr("value", variantAttrId);
            }
        }
    });

    ids = ids.filter((id) => id !== parseInt(optionId));
    parent.remove();
    $(".choose-attribute")
        .find(`option[value="${optionId}"]`)
        .prop("disabled", false);
});

// ajax select variant function
$(document).on("change", ".variant-select", function () {
    let attrs = [];
    let attrIds = [];
    let attrTitle = [];
    let curAttrId = [];

    $(".variant-item").each(function () {
        let _this = $(this);
        let arr = [];
        let arrId = [];
        let attrCatalougeId = _this
            .find(".choose-attribute option:selected")
            .val();
        let attributes = _this
            .find(`.variant-select-${attrCatalougeId}`)
            .select2("data");
        let optionContent = _this
            .find(".choose-attribute option:selected")
            .text();
        optionContent = optionContent.replace("- ", "");

        if (attributes) {
            for (let i = 0; i < attributes.length; i++) {
                let item = {};
                let id = {};
                item[optionContent] = attributes[i].text;
                arr.push(item);
                id[attrCatalougeId] = attributes[i].id;
                arrId.push(id);
                curAttrId.push(attributes[i].id);
            }
            attrTitle.push(optionContent);
            attrs.push(arr);
            attrIds.push(arrId);
        }
    });

    let newAttrTitle = attrTitle.filter(
        (value) => !currentTitle.includes(value)
    );

    currentTitle = attrTitle;

    attrs = attrs.reduce((acc, curr) =>
        acc.flatMap((d) => curr.map((e) => ({ ...d, ...e })))
    );

    attrIds = attrIds.reduce((acc, curr) =>
        acc.flatMap((d) => curr.map((e) => ({ ...d, ...e })))
    );

    if ($(".variant-table-body").length == 0) {
        $(".variant-table").html(renderVariantTable());
    }

    appendProductVersion(attrs, attrIds, newAttrTitle);

    deletedId = prevAttrId.find((id) => !curAttrId.includes(id));
    prevAttrId = curAttrId;
    if (deletedId) {
        deleteVarianTableItem(deletedId);
        return;
    }
});

// disable or active js-switch variant
$(document).on("change", ".js-switch", function () {
    let _this = $(this);
    let isChecked = _this.prop("checked");

    if (isChecked == true) {
        _this
            .parents(".col-lg-2")
            .siblings(".col-lg-10")
            .find(".disabled")
            .attr("disabled", false);
    } else {
        _this
            .parents(".col-lg-2")
            .siblings(".col-lg-10")
            .find(".disabled")
            .attr("disabled", true);
    }
});

const deleteVarianTableItem = (id) => {
    $(".variant-row").each(function () {
        let _this = $(this);
        let attrIds = String(_this.data("attrid"));
        attrIds = attrIds.split("-") ?? [attrIds];
        if (attrIds.includes(id)) {
            _this.remove();
        }
    });
};

const ajaxSelectElement = (attrCatalougeId) => {
    let html = `
            <select name="attributes[${attrCatalougeId}][]" class="variant-select  variant-select-${attrCatalougeId}" data-catid="${attrCatalougeId}" multiple></select>
            <input class="hidden" name="attr-catalouge[]" value="${attrCatalougeId}">
        `;
    return html;
};

const getVariantItem = () => {
    const title = {
        en: "Choose Attribute",
        vi: "Chọn thuộc tính",
        ja: "属性を選択",
        zh: "选择属性",
    };

    let options = "";
    listAttr.forEach((item) => {
        const disabled = ids.includes(item.id) ? "disabled" : "";
        options += `<option ${disabled} value="${item.id}">${item.name}</option>`;
    });

    return `
        <div class="row mt-20 variant-item flex flex-middle">
            <div class="col-lg-3">
                <div class="attribute-catalouge">
                    <select data-prev="0" name="attr-catalouge[]" class="choose-attribute select2-play">
                        <option value="" disabled selected>${title[lang]}</option>
                        ${options}
                    </select>
                </div>
            </div>
            <div class="col-lg-8 ajax-select">
                <input type="text" name="abc" disabled class="b-radius-4 form-control">
            </div>
            <div class="col-lg-1">
                <button type="button" class="remove-attribute btn btn-danger b-radius-4">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    `;
};

const appendProductVersion = (attrs, attrIds, attrTitle) => {
    if ($(".variant-table-body").length === 0) return;

    let thead = "";
    let body = "";
    let price = $('input[name="price"]').val();
    let code = $('input[name="code"]').val();

    if (attrTitle.length !== 0) {
        $(".attr-catalogue-thead").each(function () {
            $(this).remove();
        });

        for (let i = 0; i < currentTitle.length; i++) {
            thead += `<td class="attr-catalogue-thead">${currentTitle[i]}</td>`;
        }
    } else {
        for (let i = 0; i < attrTitle.length; i++) {
            thead += `<td class="attr-catalogue-thead">${attrTitle[i]}</td>`;
        }
    }

    for (let i = 0; i < attrs.length; i++) {
        let tdbody = "";
        let attrName = [];
        let variantAttrId = [];

        $.each(attrs[i], (index, value) => {
            tdbody += `<td class="attr-catalogue-td" data-attrname="${index}">${value}</td>`;
            attrName.push(value);
            curentTypeVariant.push(value);
        });

        $.each(attrIds[i], (index, value) => {
            variantAttrId.push(value);
        });

        let strAttrName = attrName.join("-");
        let strAttrId = variantAttrId.join("-");

        let tdHidden = `
            <td class="hidden td-variant">
                <input type="text" name="variant[quantity][]" class="variant-quantity" value="${ (OldVariants && OldVariants.quantity[i]) ? OldVariants.quantity[i] : 0}">
                <input type="text" name="variant[sku][]" class="variant-sku" value="${ (OldVariants && OldVariants.sku[i]) ? OldVariants.sku[i] : ''}">
                <input type="text" name="variant[price][]" class="variant-price" value="${ (OldVariants && OldVariants.price[i]) ? OldVariants.price[i] : 0}">
                <input type="text" name="variant[barcode][]" class="variant-barcode"  value="${ (OldVariants && OldVariants.barcode[i]) ? OldVariants.barcode[i] : 0} ">
                <input type="text" name="variant[filename][]" class="variant-filename"  value="${ (OldVariants && OldVariants.filename[i]) ? OldVariants.filename[i] : ''} ">
                <input type="text" name="variant[url][]" class="variant-url"  value="${ (OldVariants && OldVariants.url[i]) ? OldVariants.url[i] : ''}">
                <input type="text" name="variant[album][]" class="variant-album"  value="${ (OldVariants && OldVariants.album[i]) ? OldVariants.album[i] : ''}">
                <input type="text" name="attr[name][]" class="attr-name" value="${strAttrName}">
                <input type="text" name="attr[id][]" class="attr-id" value="${strAttrId}">
            </td>
        `;

        if (attrTitle.length !== 0) {
            $(".variant-table-body").html("");
        }

        if ($(`.row-${strAttrId}`).length === 0) {
            body += `
                <tr class="variant-row row-${strAttrId}" data-attrid="${strAttrId}">
                    <td>
                        <img
                            class="variant-img"
                            src="${( OldVariants && OldVariants.album[i]) ? OldVariants.album[i].split(",")[0] : '/backend/img/no-image.svg'}"
                            alt=""
                        />
                    </td>
                    ${tdbody}
                    <td class="variant-quantity" >${ (OldVariants && OldVariants.quantity[i]) ? OldVariants.quantity[i] : '---'}</td>
                    <td class="variant-price">${ (OldVariants && OldVariants.price[i]) ? OldVariants.price[i] : price}</td>
                    <td class="variant-sku">${code}-${strAttrId}</td>
                    ${tdHidden}
                </tr>
            `;
        }
    }

    $(".variant-table-body").append(body);

    $(".thead-lang").before(thead);
};

const renderVariantTable = () => {
    const title = {
        quantiy: {
            en: "Quantity",
            vi: "Số lượng",
            ja: "数量",
            zh: "数量",
        },
        price: {
            en: "Price",
            vi: "Giá tiền",
            ja: "価格",
            zh: "价格",
        },
        img: {
            en: "Image",
            vi: "Ảnh",
            ja: "画像",
            zh: "图片",
        },
    };

    return `
        <thead class="variant-table-thead">
            <td>${title.img[lang]}</td>
            <td class="thead-lang">${title.quantiy[lang]}</td>
            <td>${title.price[lang]}</td>
            <td>SKU</td>
         </thead>
        <tbody class="variant-table-body">
        </tbody>
    `;
};

$(document).on("click", ".cancel-variant-update", function () {
    let _this = $(this);
    _this.parents(".update-variant-box").remove();
});

// save variant event
$(document).on("click", ".save-variant-update", function () {
    let _this = $(this);
    let parent = _this.parents(".update-variant-box");

    const variant = {
        quantity: $("input[name='variant-quantity']").val(),
        sku: $("input[name='variant-sku']").val(),
        price: $("input[name='variant-price']").val(),
        barcode: $("input[name='variant-barcode']").val(),
        filename: $("input[name='variant-filename']").val(),
        url: $("input[name='variant-url']").val(),
        album: variantAlbum,
    };

    $.each(variant, function (key, value) {
        parent
            .prev(".variant-row")
            .find(`input[name='variant[${key}][]']`)
            .val(value);
        parent
            .prev(".variant-row")
            .find(`td[class='variant-${key}']`)
            .text(value);
    });

    parent
        .prev(".variant-row")
        .find(`img[class='variant-img']`)
        .attr("src", variantAlbum[0] ?? "/backend/img/no-image.svg");

    _this.parents(".update-variant-box").remove();
});

$(document).on("click", ".variant-row", function () {
    let _this = $(this);
    let inputVariant = _this.find("input[name^='variant[']");
    let variants = {};

    for (let input of inputVariant) {
        let _input = $(input);
        let key = _input.attr("class").replace("variant-", "");
        variants[key] = _input.val();
    }

    let variantUpdateTable = renderVariantUpdateTable(variants);
    if ($(".update-variant-box").length == 0) {
        _this.after(variantUpdateTable);
        $(".js-switch").each((index, element) => {
            var switchery = new Switchery(element, {
                color: "#1AB394",
            });
        });
    }
});

$(document).ready(function(){
    $(".variant-select").each(function (key, index) {
        let _this = $(this);
        let attrCatalougeId =  _this.data("catid");

        if(attributes !== ''){
            $.get('/ajax/attr/loadAttr', {
                attributes: attributes,
                attrCatalougeId: attrCatalougeId
            }, function(json){
                if(json.items && json.items.length){
                    for(let i = 0; i < json.items.length; i++){
                        var option = new Option(json.items[i].name, json.items[i].id, true, true);
                        _this.append(option).trigger('change');
                    }
                }

            });
        }

        initAjaxSelect(_this);
    });
})

const renderVariantUpdateTable = (variants) => {
    let price = $('input[name="price"]').val();
    let code = $('input[name="code"]').val();
    let attrId = $('.variant-row').data('attrid');
    const title = {
        updateVersion: {
            en: "Update Version",
            vi: "Cập Nhật phiên bản",
            ja: "アップデートバージョン",
            zh: "您正在使用最新版本",
        },
        cancel: {
            en: "Cancel",
            vi: "Hủy",
            ja: "キャンセル",
            zh: "取消",
        },
        save: {
            en: "Save",
            vi: "Lưu",
            ja: "保存",
            zh: "保存",
        },
        clickToUpload: {
            en: "Click here to upload images",
            vi: "Click vào đây để tải ảnh lên",
            ja: "画像をアップロードするにはここをクリック",
            zh: "点击这里上传图片",
        },
        quantiy: {
            en: "Quantity",
            vi: "Số lượng",
            ja: "数量",
            zh: "数量",
        },
        price: {
            en: "Price",
            vi: "Giá tiền",
            ja: "",
            zh: "价格",
        },
        barcode: {
            en: "Barcode",
            vi: "Mã vạch",
            ja: "バーコード",
            zh: "条形码",
        },
        manageStock: {
            en: "Manage Stock",
            vi: "Quản lý kho",
            ja: "在庫を管理する",
            zh: "管理库存",
        },
        manageFile: {
            en: "Manage File",
            vi: "Quản lí File",
            ja: "ファイルを管理する",
            zh: "管理文件",
        },
        fileName: {
            en: "File name",
            vi: "Tên file",
            ja: "ファイル名",
            zh: "文件名",
        },
        link: {
            en: "Link",
            vi: "Đường dẫn",
            ja: "リンク",
            zh: "链接",
        },
    };

    let img = "";
    if (variants.album !== "") {
        const album = variants.album.split(",");
        for (item of album) {
            img += `
                <li class="ui-state-default">
                    <div class="thumb">
                        <span class="span image image-scaledown">
                            <img src="${item}" alt="">
                        </span>
                        <button type="button" class="delete-image">
                            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                        </button>
                    </div>
                </li>
            `;
        }
    }

    return `
            <tr class="update-variant-box">
                <td colspan="6">
                    <div class="updateVariant ibox">
                        <div class="ibox-title">
                            <div class="flex flex-middle flex-space-between">
                                <h5>${title.updateVersion[lang]}</h5>
                                <div class="button-group">
                                    <div class="flex flex-middle gap-10">
                                        <button type="button"
                                            class="btn btn-danger cancel-variant-update">${
                                                title.cancel[lang]
                                            }</button>
                                        <button type="button"
                                            class="btn btn-success save-variant-update">${
                                                title.save[lang]
                                            }</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="click-to-upload-variant ${
                                img !== "" ? "hidden" : ""
                            }">
                                <div class="icon">
                                    <a href="#" class="upload-variant-picture">
                                        <svg width="100px" height="100px" viewBox="0 0 48 48" id="a"
                                            xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                                stroke="#CCCCCC" stroke-width="0.9600000000000002"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <defs>
                                                    <style>
                                                        .b {
                                                            fill: none;
                                                            stroke: #d3dbe2;
                                                            stroke-linecap: round;
                                                            stroke-linejoin: round;
                                                        }
                                                    </style>
                                                </defs>
                                                <path class="b"
                                                    d="M29.4995,12.3739c.7719-.0965,1.5437,.4824,1.5437,1.2543h0l2.5085,23.8312c.0965,.7719-.4824,1.5437-1.2543,1.5437l-23.7347,2.5085c-.7719,.0965-1.5437-.4824-1.5437-1.2543h0l-2.5085-23.7347c-.0965-.7719,.4824-1.5437,1.2543-1.5437l23.7347-2.605Z">
                                                </path>
                                                <path class="b"
                                                    d="M12.9045,18.9347c-1.7367,.193-3.0874,1.7367-2.8945,3.5699,.193,1.7367,1.7367,3.0874,3.5699,2.8945,1.7367-.193,3.0874-1.7367,2.8945-3.5699s-1.8332-3.0874-3.5699-2.8945h0Zm8.7799,5.596l-4.6312,5.6925c-.193,.193-.4824,.2894-.6754,.0965h0l-1.0613-.8683c-.193-.193-.5789-.0965-.6754,.0965l-5.0171,6.1749c-.193,.193-.193,.5789,.0965,.6754-.0965,.0965,.0965,.0965,.193,.0965l19.9719-2.1226c.2894,0,.4824-.2894,.4824-.5789,0-.0965-.0965-.193-.0965-.2894l-7.8151-9.0694c-.2894-.0965-.5789-.0965-.7719,.0965h0Z">
                                                </path>
                                                <path class="b"
                                                    d="M16.2814,13.8211l.6754-6.0784c.0965-.7719,.7719-1.3508,1.5437-1.2543l23.7347,2.5085c.7719,.0965,1.3508,.7719,1.2543,1.5437h0l-2.5085,23.7347c0,.6754-.7719,1.2543-1.5437,1.2543l-6.1749-.6754">
                                                </path>
                                                <path class="b"
                                                    d="M32.7799,29.9337l5.3065,.5789c.2894,0,.4824-.193,.5789-.4824,0-.0965,0-.193-.0965-.2894l-5.789-10.5166c-.0965-.193-.4824-.2894-.6754-.193h0l-.3859,.3859">
                                                </path>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                                <div class="small-text">${
                                    title.clickToUpload[lang]
                                }</div>
                            </div>
                            <div class="upload-list-variant">
                                <div class="row">
                                    <ul id="sortable-variant" class="clearfix data-variantAlbum sortui ui-sortable">
                                        ${img}
                                    </ul>
                                    <input type="hidden" id="variantAlbum" name="variantAlbum" value="">

                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-2 flex flex-col flex-middle">
                                    <label for="" class="control-label">${
                                        title.manageStock[lang]
                                    }</label>
                                    <input type="checkbox" class="js-switch"
                                        ${
                                            variants.quantity == "" ||
                                            variants.quantity == 0
                                                ? ""
                                                : "checked"
                                        }
                                    >
                                </div>
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label for="variant-quantity"
                                                class="control-label">${
                                                    title.quantiy[lang]
                                                }</label>
                                            <input class="form-control text-right disabled"
                                                ${
                                                    variants.quantity == "" ||
                                                    variants.quantity == 0
                                                        ? "disabled"
                                                        : ""
                                                }
                                                type="text" id="variant-quantity"
                                                name="variant-quantity" value="${
                                                    variants.quantity !== ""
                                                        ? variants.quantity
                                                        : 0
                                                }"
                                            >
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="variant-sku" class="control-label">SKU</label>
                                            <input class="form-control text-right" type="text" id="variant-sku"
                                                name="variant-sku" value="${
                                                    variants.sku !== ""
                                                        ? variants.sku
                                                        : `${code}-${attrId}`
                                                }">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="variant-price"
                                                class="control-label">${
                                                    title.price[lang]
                                                }</label>
                                            <input class="form-control text-right" type="text" id="variant-price"
                                                name="variant-price" value="${
                                                    variants.price !== ""
                                                        ? variants.price
                                                        : price
                                                }">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="variant-barcode"
                                                class="control-label">${
                                                    title.barcode[lang]
                                                }</label>
                                            <input class="form-control text-right" type="text" id="variant-barcode"
                                                name="variant-barcode" value="${
                                                    variants.barcode !== ""
                                                        ? variants.barcode
                                                        : 0
                                                }">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-2 flex flex-col flex-middle">
                                    <label for="" class="control-label">${
                                        title.manageFile[lang]
                                    }</label>
                                    <input type="checkbox" class="js-switch"
                                        ${
                                            variants.filename == "" &&
                                            variants.url == ""
                                                ? ""
                                                : "checked"
                                        }
                                    >
                                </div>
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="variant-filename"
                                                class="control-label">${
                                                    title.fileName[lang]
                                                }</label>
                                            <input class="form-control text-right disabled"
                                                ${
                                                    variants.filename == "" &&
                                                    variants.url == ""
                                                        ? "disabled"
                                                        : ""
                                                }
                                                type="text" id="variant-filename"
                                                name="variant-filename" value="${
                                                    variants.filename
                                                }"
                                            >
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="variant-url"
                                                class="control-label">${
                                                    title.link[lang]
                                                }</label>
                                            <input class="form-control text-right disabled"
                                                ${
                                                    variants.filename == "" &&
                                                    variants.url == ""
                                                        ? "disabled"
                                                        : ""
                                                }
                                                type="text" id="variant-url"
                                                name="variant-url" value="${
                                                    variants.url
                                                }"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
    `;
};
