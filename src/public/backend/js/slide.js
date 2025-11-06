(function($) {
'use strict';
var FUNCT = {};
var slideList = [];

FUNCT.addSilde = () => {
    $(document).on('click', '.addSlide', function(e){
        e.preventDefault();
        slideUpload.open();
    })
}

FUNCT.turnOnSortable = () => {
    $("#sortable").sortable();
}

FUNCT.deleteSlide = () => {
    $(document).on('click', '.deleteSlide', function(e){
        e.preventDefault();
        let _this = $(this);
        let parent = _this.parents('.ui-state-default');
        parent.remove();

    })
}

// execute function
$(document).ready(()=>{
    FUNCT.addSilde();
    FUNCT.turnOnSortable();
    FUNCT.deleteSlide();
})

// cloudinary upload Image
const slideUpload = cloudinary.createUploadWidget(
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
            slideList.push(result.info.asset_id);
            $(".slide-list").append(slideHTML(result.info.asset_id, result.info.url));
        }
    }
);

const slideHTML = (id, imgUrl) => {
    const translate = {
        commonInf: {
            en: "Common Information",
            vi: "Thông tin chung",
            zh: "共通信息",
            ja: "共通情報"
        },
        desc: {
            en: "Description",
            vi: "Mô tả",
            zh: "描述",
            ja: "説明"
        },
        newTab: {
            en: "Open in new tab",
            vi: "Mở trong tab mới",
            zh: "在新标签页中打开",
            ja: "新しいタブで開く"
        },
        iTitle: {
            en: "Image Title",
            vi: "Tiêu đề ảnh",
            zh: "图片标题",
            ja: "画像タイトル"
        },
        iDesc: {
            en: "Image Description",
            vi: "Mô tả ảnh",
            zh: "图片描述",
            ja: "画像の説明"
        }
    }

    return `
    <div class="row ui-state-default">
        <div class="col-lg-3 relative">
            <img src="${imgUrl}"
            alt="" class="img-cover li">
            <input type="hidden" name="slides[image][]" value="${imgUrl}">
            <input type="hidden" name="slides[id][]" value="${id}">
            <button class="btn btn-danger deleteSlide" type="button">
                <i class="fa fa-trash fa-lg"></i>
            </button>
        </div>
        <div class="col-lg-9">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-1-${id}"
                            aria-expanded="true">
                            ${translate.commonInf[lang]}
                        </a>
                    </li>
                    <li class=""><a data-toggle="tab" href="#tab-2-${id}"
                        aria-expanded="false">SEO</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="tab-1-${id}" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-row">
                                        <label for="slide-desc-${id}" class="control-label text-right text-capitalize">
                                            ${translate.desc[lang]}
                                        </label>
                                        <textarea class="form-control tiny-editor" type="text" rows="3" name="slides[desc][]" id="slide-desc-${id}">
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-10 flex flex-space-between flex-middle">
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="slides[url][]" placeholder="URL">
                                </div>
                                <div class="col-lg-3 flex flex-end gap-10 flex-middle">
                                    <input type="checkbox" class="m-0" name="slides[newtab][]" value="_blank" id="slide_newtab">
                                    <label for="slide_newtab" class="m-0 text-500 text-sm"> ${translate.newTab[lang]}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-2-${id}" class="tab-pane">
                        <div class="panel-body">
                                <div class="col-lg-12">
                                    <div class="form-row">
                                        <label for="slide-name-${id}" class="control-label text-right text-capitalize">
                                            ${translate.iTitle[lang]}
                                        </label>
                                        <input class="form-control" type="text" name="slides[name][]" id="slide-name-${id}">
                                        </input>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-5">
                                    <div class="form-row">
                                        <label for="slide-alt-${id}" class="control-label text-right text-capitalize">
                                            ${translate.iDesc[lang]}
                                        </label>
                                        <input class="form-control" type="text" name="slides[alt][]" id="slide-alt-${id}">
                                        </input>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    `
}

})(jQuery)
