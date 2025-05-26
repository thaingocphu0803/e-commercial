let ward_select = $("#ward_id");
let district_select = $("#district_id");
const _token = $('meta[name="csrf-token"]').attr("content");
let album = [];
let variantAlbum = [];
let ids = [];
let currentTitle = [];
let curentVariant = 0;
let curentTypeVariant = [];
let prevAttrId = [];
let deletedId = null;

const cloudName = "my-could-api";
const uploadPreset = "laravel_app";
const folder = "ImageFolder";
const maxFiles = 1;
const width = 300;
const height = 300;

const tinyPlugins = ["link image table"];

const tinyToolBar =
    "undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image table";

// get district api
$(document).on("change", "#province_id", async function () {
    let _this = $(this);
    let province_id = currentId;

    try {
        const districts = await $.ajax({
            type: "GET",
            url: "/ajax/location/district",
            data: { province_id },
            dataType: "json",
        });

        district_select.html(
            `<option selected disabled>Choose district</option>`
        );

        ward_select.html(`<option selected disabled>Choose ward</option>`);

        districts.forEach((district) => {
            district_select.append(
                `<option value="${district.code}" ${
                    districtId == district.code ? "selected" : ""
                } >${district.name}</option>`
            );
        });
    } catch (err) {
        console.log(err);
    }
});

// get ward api
$(document).on("change", "#district_id", async function () {
    let _this = $(this);
    let district_id = null;

    if (typeof districtId !== "undefined") {
        district_id = currentId ?? districtId;
    }

    try {
        const response = await $.ajax({
            type: "GET",
            url: "/ajax/location/ward",
            data: { district_id },
            dataType: "json",
        });

        ward_select.html(`<option selected disabled>Choose ward</option>`);

        response.forEach((ward) => {
            ward_select.append(
                `<option value="${ward.code}" ${
                    wardId == ward.code ? "selected" : ""
                } >${ward.name}</option>`
            );
        });
    } catch (err) {
        console.log(err);
    }
});

// change status
$(document).on("change", ".status", async function (e) {
    e.preventDefault();
    let _this = $(this);
    let requestData = {
        value: currentId,
        modelId: _this.attr("data-modelId"),
        model: _this.attr("data-model"),
        field: _this.attr("data-field"),
        _token: _token,
    };
    try {
        const response = await $.ajax({
            type: "POST",
            url: "/ajax/dashboard/changeStatus",
            data: requestData,
            dataType: "json",
        });

        console.log(response);
    } catch (err) {
        console.log(err);
    }
});

//check all user
$(document).on("click", ".checkAll", function () {
    let checkAllState = $(this).prop("checked");

    $(".checkItem").prop("checked", checkAllState);

    $(".checkItem").each(function () {
        let _this = $(this);

        if (_this.prop("checked")) {
            _this.closest("tr").addClass("active-bg");
        } else {
            _this.closest("tr").removeClass("active-bg");
        }
    });
});

//change background checkItem
$(document).on("click", ".checkItem", function () {
    let _this = $(this);
    let allCheck = $(".checkItem:checked").length === $(".checkItem").length;

    if (_this.prop("checked")) {
        _this.closest("tr").addClass("active-bg");
    } else {
        _this.closest("tr").removeClass("active-bg");
    }

    $(".checkAll").prop("checked", allCheck);
});

//change user status all
$(document).on("click", ".changeStatusAll", async function (e) {
    e.preventDefault();

    let _this = $(this);
    let ids = [];

    $(".checkItem:checked").each(function () {
        let checkItem = $(this);
        ids.push(checkItem.val());
    });

    let requestData = {
        value: _this.attr("data-value"),
        ids,
        model: _this.attr("data-model"),
        field: _this.attr("data-field"),
        _token: _token,
    };

    const response = await $.ajax({
        type: "POST",
        url: "/ajax/dashboard/changeStatusAll",
        data: requestData,
        dataType: "json",
    });

    if (response.flag) {
        const cssActive1 = `
                            background-color: rgb(26, 179, 148); border-color: rgb(26, 179, 148);
                            box-shadow: rgb(26, 179, 148) 0px 0px 0px 16px inset; transition: border 0.4s,
                            box-shadow 0.4s, background-color 1.2s;
                        `;
        const cssActive2 = `
                            left: 20px; background-color: rgb(255, 255, 255);
                            transition: background-color 0.4s, left 0.2s;
                        `;

        const cssDeActive1 = `
                            box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223);
                            background-color: rgb(255, 255, 255); transition: border 0.4s, box-shadow 0.4s;
                        `;
        const cssDeActive2 = `
                            left: 0px; transition: background-color 0.4s, left 0.2s;
                        `;
        if (requestData.value == 1) {
            for (let i = 0; i < ids.length; i++) {
                $(`.js-switch-${ids[i]}`)
                    .find("span.switchery")
                    .attr("style", cssActive1)
                    .find("small")
                    .attr("style", cssActive2);
            }
        }

        if (requestData.value == 2) {
            for (let i = 0; i < ids.length; i++) {
                $(`.js-switch-${ids[i]}`)
                    .find("span.switchery")
                    .attr("style", cssDeActive1)
                    .find("small")
                    .attr("style", cssDeActive2);
            }
        }
    }
});

//re get location api
$(() => {
    if (typeof provinceId !== "undefined" && provinceId != "") {
        $("#province_id").val(provinceId).trigger("change");
    }

    if (typeof districtId !== "undefined" && districtId != "") {
        $("#district_id").val(districtId).trigger("change");
    }

    let img_url = $("#img_url").text().trim();

    if (img_url) {
        let _this = $("#img_show");
        _this.attr("src", img_url);
        _this.removeClass("hidden");
    }
});

// select2 widget
$(".select2").select2();

// cloudinary upload widget
const ImageWidget = cloudinary.createUploadWidget(
    {
        cloudName,
        uploadPreset,
        folder,
        cropping: true,
        maxFiles,
        transformation: [{ width, height, crop: "thumb" }],
        sources: ["local", "url", "image_search"],
        googleApiKey: "AIzaSyBMnZuJmBV2_6QHMYDOleTyxe67M6RplNg",
        searchBySites: ["all", "cloudinary.com"],
        searchByRights: true,
    },
    (error, result) => {
        if (!error && result && result.event === "success") {
            $("#img_url").text(`${result.info.url}`);
            $("#img_url").attr("href", `${result.info.url}`);
            $("#img_show")?.attr("src", `${result.info.url}`);
            $("#img_show")?.removeClass("hidden");
            $("#image").val(btoa(result.info.url));
        }
    }
);

$(document).on("click", "#upload_widget", function () {
    ImageWidget.open();
});

// cloudinary upload Image
const ImageUpload = cloudinary.createUploadWidget(
    {
        cloudName,
        uploadPreset,
        folder: "album",
        multiple: true,
        transformation: [{ width, height, crop: "thumb" }],
        sources: ["local", "url", "image_search"],
        googleApiKey: "AIzaSyBMnZuJmBV2_6QHMYDOleTyxe67M6RplNg",
        searchBySites: ["all", "cloudinary.com"],
        searchByRights: true,
    },
    (error, result) => {
        if (!error && result && result.event === "success") {
            $("#sortable").append(`
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

            $(".click-to-upload").addClass("hidden");
            $(".upload-list").removeClass("hidden");

            album.push(result.info.url);
        }
    }
);

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

$(document).on("click", ".upload-picture", function (e) {
    e.preventDefault();
    ImageUpload.open();
});

$(document).on("click", ".upload-variant-picture", function (e) {
    e.preventDefault();
    variantImageUpload.open();
});

//delete picture
$(document).on("click", ".delete-image", function () {
    let _this = $(this);

    let item = _this.parents(".ui-state-default");
    let itemUrl = item.find("img[src]").attr("src");
    item.remove();

    album = album.filter((url) => {
        return url != itemUrl;
    });

    if ($(`.ui-state-default`).length == 0) {
        $(".click-to-upload").removeClass("hidden");
        $(".upload-list").addClass("hidden");
    }
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
//add album to input value
$(document).on("submit", "#post_catalouge_form", function (e) {
    e.preventDefault();

    if (album.length > 0) {
        $("#album").val(JSON.stringify(album));
    } else {
        $("#album").val(null);
    }

    this.submit();
});

//get postCatalouge Album

$(".img_album").each(function () {
    let src = $(this).attr("src");
    album.push(src);
});

//TinyMCE

$(".tiny-editor").each(function () {
    let editorId = $(this).attr("id");

    tinymce.init({
        selector: `#${editorId}`,
        height: height,
        menubar: false,
        plugins: tinyPlugins,
        toolbar: tinyToolBar,
        image_title: true,
        image_caption: true,
        automatic_uploads: true,
        file_picker_types: "image",
        images_upload_url: `/ajax/dashboard/upload/image?_token=${_token}`,
        images_reuse_filename: true,

        content_style:
            "body { font-family:Helvetica,Arial,sans-serif; font-size:16px }",
    });
});

$("#sortable").sortable();

$("#sortable").disableSelection();

$("#sortable-variant").sortable();

$("#sortable-variant").disableSelection();

//toggle variant checked
$("#variantCheckbox").on("change", function () {
    let _this = $(this);
    if (_this.is(":checked")) {
        $("#variant-wrapper").removeClass("hidden");
    } else {
        $("#variant-wrapper").addClass("hidden");
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
    let optionContent = parent.find(`select[name="attr"] option:selected`).text();
    optionContent =  optionContent.replace("- ", "")

    $(".attr-catalogue-thead").each(function(){
        let _this = $(this);
        if(_this.text() == optionContent){
            _this.remove();
        }
    })

    $(".attr-catalogue-td").each(function(){
        let _this = $(this);
        let dataAttrName = _this.data('attrname');
        let content  = _this.text();

        console.log(dataAttrName);
        console.log(content);

        // if(dataAttrName == optionContent){
        //     _this.remove();
        // }
        let variantAttrName = _this.siblings('.td-variant').find('input[name="attr[name][]"]').val();
        variantAttrName = String(variantAttrName).split('-');

        let variantAttrId = _this.siblings('.td-variant').find('input[name="attr[id][]"]').val();
        variantAttrId = String(variantAttrId).split('-');

        console.log(variantAttrName)
                console.log(variantAttrId)

        for(let i = 0; i < variantAttrName.length; i++){
            if(variantAttrName[i] == content){
                variantAttrName.splice(i, 1);
                variantAttrName = variantAttrName.join('-');
                _this.siblings('.td-variant').find('input[name="attr[name][]"]').attr('value', variantAttrName);

                variantAttrId.splice(i, 1);
                variantAttrId = variantAttrId.join('-');
                _this.siblings('.td-variant').find('input[name="attr[id][]"]').attr('value', variantAttrId);
            }
        }

    })

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

    deletedId = prevAttrId.find(id =>!curAttrId.includes(id));
    prevAttrId = curAttrId;
    if(deletedId){
        deleteVarianTableItem(deletedId);
        return
    }


    attrs = attrs.reduce((acc, curr) =>
        acc.flatMap((d) => curr.map((e) => ({ ...d, ...e })))
    );

    attrIds = attrIds.reduce((acc, curr) =>
        acc.flatMap((d) => curr.map((e) => ({ ...d, ...e })))
    );

    let newAttrTitle = attrTitle.filter(
        (value) => !currentTitle.includes(value)
    );

    currentTitle = attrTitle;

    if ($(".variant-table-body").length == 0) {
        $(".variant-table").html(renderVariantTable());
    }

    appendProductVersion(attrs, attrIds, newAttrTitle);
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
    $(".variant-row").each(function(){
        let _this = $(this);
        let ids = String(_this.data('attrid'));
        ids = ids.split('-') ?? [ids];
        if(ids.includes(id)){
            _this.remove();
        }
    })
}

const ajaxSelectElement = (attrCatalougeId) => {
    let html = `<select name="attr[${attrCatalougeId}][]" class="variant-select  variant-select-${attrCatalougeId}" data-catid="${attrCatalougeId}" multiple></select>`;
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
                    <select data-prev="0" name="attr" class="choose-attribute select2-play">
                        <option value="" disabled selected>${title[lang]}</option>
                        ${options}
                    </select>
                </div>
            </div>
            <div class="col-lg-8 ajax-select">
                <input type="text" name="" disabled class="b-radius-4 form-control">
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



    for (let i = 0; i < attrTitle.length; i++) {
        thead += `<td class="attr-catalogue-thead">${attrTitle[i]}</td>`;
    }

    for (let i = 0; i < attrs.length; i++) {
        let tdbody = "";
        let attrName = [];
        let variantAttrId = [];
        let numberVariant = Object.keys(attrs[i]).length;

        $.each(attrs[i], (index, value) => {
            tdbody += `<td class="attr-catalogue-td" data-attrname="${index}">${value}</td>`;
            attrName.push(value);
            curentTypeVariant.push(value);
        });

        $.each(attrIds[i], (index, value) => {
            variantAttrId.push(value);
        });

        let strAttrName = attrName.join("-");
        let strAttrId = variantAttrId.sort().join("-");

        let tdHidden = `
            <td class="hidden td-variant">
                <input type="text" name="variant[quantity][]" class="variant-quantity">
                <input type="text" name="variant[sku][]" class="variant-sku">
                <input type="text" name="variant[price][]" class="variant-price">
                <input type="text" name="variant[barcode][]" class="variant-barcode">
                <input type="text" name="variant[filename][]" class="variant-filename">
                <input type="text" name="variant[url][]" class="variant-url">
                <input type="text" name="variant[album][]" class="variant-album">
                <input type="text" name="attr[name][]" class="attr-name" value="${strAttrName}">
                <input type="text" name="attr[id][]" class="attr-id" value="${strAttrId}">
            </td>
        `;

        if (curentVariant != numberVariant) {
            $(".variant-table-body").html('');
        }

        if($(`.row-${strAttrId}`).length === 0){
            body += `
                <tr class="variant-row row-${strAttrId}" data-attrid="${strAttrId}">
                    <td><img class="variant-img" src="/backend/img/no-image.svg" alt=""/></td>
                    ${tdbody}
                    <td class="variant-quantity" >---</td>
                    <td class="variant-price">---</td>
                    <td class="variant-sku">---</td>
                    ${tdHidden}
                </tr>
            `;
        }

        curentVariant = numberVariant;
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
            ja: "",
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

const renderVariantUpdateTable = (variants) => {
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
                                                        : 0
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
                                                        : 0
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
