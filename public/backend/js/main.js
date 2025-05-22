let ward_select = $("#ward_id");
let district_select = $("#district_id");
const _token = $('meta[name="csrf-token"]').attr("content");
let album = [];
let ids = [];

const cloudName = "my-could-api";
const uploadPreset = "laravel_app";
const folder = "ImageFolder";
const maxFiles = 1;
const width = 300;
const height = 300;

const tinyPlugins = ['link image table'];

const tinyToolBar = 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image table';

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

            album.push(result.info.url);
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

    album = album.filter((url) => {
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
    ids = ids.filter((id) => id !== parseInt(optionId));
    parent.remove();
    $(".choose-attribute")
        .find(`option[value="${optionId}"]`)
        .prop("disabled", false);
});

// ajax select variant function
$(document).on("change", ".variant-select", function () {
    let attrs = [];
    let attrTitle = [];
    $(".variant-item").each(function () {
        let _this = $(this);
        let arr = [];
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
                item[optionContent] = attributes[i].text;
                arr.push(item);
            }
            attrTitle.push(optionContent);
            attrs.push(arr);
        }
    });

    attrs = attrs.reduce((acc, curr) =>
        acc.flatMap((d) => curr.map((e) => ({ ...d, ...e })))
    );

    $(".variant-table").html(renderVariantTable(attrs, attrTitle));
});

// disable or active js-switch variant
$(document).on("change",".js-switch", function(){
    let _this =$(this);
    let isChecked = _this.prop('checked');

    if(isChecked == true){
        _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').attr('disabled', false)
    }else{
        _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').attr('disabled', true)
    }
});

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

const renderVariantTable = (attrs, attrTitle) => {
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

    let thead = "";
    let body = "";

    for(let i = 0; i < attrTitle.length;i++){
        thead += `<td>${attrTitle[i]}</td>`;
    }

    for(let i = 0; i < attrs.length; i++){
        let tdbody = ""
        $.each(attrs[i], (index, value)=>{

            console.log(index, value);
            tdbody += `<td>${value}</td>`
        })
        body += `
            <tr class="variant-row">
                <td><img class="product-img" src=""/></td>
                ${tdbody}
                <td>---</td>
                <td>---</td>
                <td>---</td>
            </tr>
        `
    }

    return `
        <thead>
            <td>${title.img[lang]}</td>
            ${thead}
            <td>${title.quantiy[lang]}</td>
            <td>${title.price[lang]}</td>
            <td>SKU</td>
         </thead>
        <tbody>
            ${body}
        </tbody>
    `;
};

