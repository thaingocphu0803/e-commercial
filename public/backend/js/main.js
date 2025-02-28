let ward_select = $("#ward_id");
let district_select = $("#district_id");
const _token = $('meta[name="csrf-token"]').attr("content");
let album = [];

const cloudName = "my-could-api";
const uploadPreset = "laravel_app";
const folder = "ImageFolder";
const maxFiles = 1;
const width = 300;
const height = 300;

const tinyPlugins = [
    'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link',
    'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount','checklist',
    'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed','a11ychecker',
    'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable','advcode', 'editimage',
    'advtemplate', 'mentions', 'tinycomments', 'tableofcontents','footnotes', 'mergetags',
    'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
  ]

const tinyToolBar = `
        undo redo | blocks fontfamily fontsize | bold italic underline strikethrough |
        link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography |
        align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat
    `;


// get district api
$(document).on("change", "#province_id", async function () {
    let _this = $(this);
    let province_id = _this.val();

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
        district_id = _this.val() ?? districtId;
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
        value: _this.val(),
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
    console.log(ids);

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

    let img_url = $('#img_url').text().trim();

    if (img_url) {
        let _this = $('#img_show');
        _this.attr('src', img_url);
        _this.removeClass('hidden');

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

            console.log(result.info);
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
        folder: 'album',
        multiple: true,
        transformation: [{ width, height, crop: "thumb" }],
        sources: ["local", "url", "image_search"],
        googleApiKey: "AIzaSyBMnZuJmBV2_6QHMYDOleTyxe67M6RplNg",
        searchBySites: ["all", "cloudinary.com"],
        searchByRights: true,
    },
    (error, result) => {
        if (!error && result && result.event === "success") {

            $('#sortable').append(`
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
            `)

            $('.click-to-upload').addClass('hidden');
            $('.upload-list').removeClass('hidden');

            album.push(result.info.url);
        }
    }

);

$(document).on("click", ".upload-picture", function (e) {
    e.preventDefault();
    ImageUpload.open();

});

//delete picture
$(document).on("click", '.delete-image', function () {
    let _this = $(this);

    let item = _this.parents('.ui-state-default');
    let itemUrl = item.find("img[src]").attr('src');
    item.remove();

    album = album.filter((url)=>{
        return url != itemUrl
    } )

if($(`.ui-state-default`).length == 0 ){
        $('.click-to-upload').removeClass('hidden');
        $('.upload-list').addClass('hidden');
    }
})
//add album to input value
$(document).on('submit', '#post_catalouge_form', function(e){
    e.preventDefault();

    if(album.length > 0){
        $('#album').val(JSON.stringify(album));
    }else{
        $('#album').val(null);
    }


    this.submit();
})

//get postCatalouge Album

$('.img_album').each(function(){
    let src = $(this).attr('src');
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
          tinycomments_mode: 'embedded',
          tinycomments_author: 'Author name',
          mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
          ],

          image_title: true,
          image_caption: true,
          automatic_uploads: true,
          file_picker_types: 'image',
          images_upload_url: `/ajax/dashboard/upload/image?_token=${_token}`,
          images_reuse_filename: true,

          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
    });

});

$('#sortable').sortable();

$("#sortable").disableSelection();

