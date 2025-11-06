(function ($) {
    "use stricrt";
    let FUNCT = {};
    let checkedList =
        typeof listChoosenMenu !== "undefined" && listChoosenMenu.length
            ? listChoosenMenu
            : [];
    let timeoutId;
    let currentPage;
    let removeMenuList = [];


    FUNCT.createMenuCatalougeEvent = async () => {
        $(document).on(
            "click",
            ".create_menu_catalouge_btn",
            async function (e) {

                let _form = $(this).parents('.create-menu-catalouge');
                let name = _form
                    .find('input[name="menu_catalouge_name"]')
                    .val();
                let keyword = _form
                    .find('input[name="menu_catalouge_keyword"]')
                    .val();
                let requestData = {
                    name,
                    keyword,
                    _token,
                };
                let message = {
                    en: {
                        1: "failed to create menu catalouge.",
                        0: "create menu catalouge successfully.",
                    },
                    vi: {
                        1: "Tạo danh mục menu thất bại.",
                        0: "Tạo danh mục menu thành công.",
                    },
                    zh: {
                        1: "创建菜单目录失败。",
                        0: "菜单目录创建成功。",
                    },
                    ja: {
                        1: "メニューカタログの作成に失敗しました。",
                        0: "メニューカタログを正常に作成しました。",
                    },
                };

                try {
                    let response = await $.ajax({
                        type: "POST",
                        url: "/ajax/menu/createCatalouge",
                        data: requestData,
                        dataType: "json",
                    });
                    if (response.code == 0) {
                        $("#create_menu_catalouge_message")
                            .removeClass("text-danger")
                            .addClass("text-success")
                            .text(message[lang][response.code]);

                        let option = `<option value="${response.data.id}">${response.data.name}</option>`;
                        $("#menu_catalouge_id").append(option);
                    } else {
                        $("#create_menu_catalouge_message")
                            .removeClass("text-success")
                            .addClass("text-danger")
                            .text(message[lang][response.code]);
                    }
                    setTimeout(function () {
                        $("#create_menu_catalouge_message").fadeOut();
                    }, 3000);
                } catch (e) {
                    let errors = e.responseJSON.errors;
                    $.each(errors, function (key, val) {
                        $(`#error_menu_catalouge_${key}`).text(val);
                    });
                }
            }
        );
    };

    FUNCT.addMenuRowEvent = (data = {}) => {
        $(document).on("click", ".menu_row_add_btn", function () {
            let _this = $(this);
            let row = FUNCT.RowMenu();

            _this.parents('.row')
                .find(".menu_row_notification")
                .addClass("hidden");

            _this.parents('.row').find(".menu-wrapper").append(row);
        });
    };

    FUNCT.RowMenu = (data) => {
        return `
            <div class="row mt-20 menu-row ${
                typeof data !== "undefined" ? "menu-row-" + data.canonical : ""
            }">
                <div class="col-lg-4">
                    <input type="text" class="form-control" value="${
                        typeof data !== "undefined" ? data.name : ""
                    }" name="menu[name][]">
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control" value="${
                        typeof data !== "undefined" ? data.canonical : ""
                    }" name="menu[canonical][]">
                </div>
                <div class="col-lg-2">
                    <input type="int" class="form-control text-right" value="0" name="menu[position][]">
                </div>
                <div class="col-lg-2 flex flex-center flex-middle">
                    <a href="#" class="delete-menu-row text-danger">
                        <i class="fa fa-times fa-2x"></i>
                    </a>
                    <input type="" name="menu[id][]" value="0" hidden>
                </div>
            </div>
        `;
    };

    FUNCT.deleteMenuRowEvent = () => {
        $(document).on("click", ".delete-menu-row", function () {
            let _this = $(this);
            let parent = _this.parents(".menu-row");
            let canonical = parent.find('input[name="menu[canonical][]"]').val();
            let id = parent.find('input[name="menu[id][]"]').val();

            parent.remove();
            if ($(".menu-row").length === 0) {
                $(".menu-wrapper")
                    .find(".menu_row_notification")
                    .removeClass("hidden");
            }

            checkedList = checkedList.filter((item)=> item !== canonical);
            $(`.menu-item`).find(`input[id="${canonical}"]`).prop('checked', false);

            if(parseInt(id) !== 0){
                removeMenuList.push(id);
            }

            console.log(removeMenuList);
            if(removeMenuList.length){
                $('input[name="menu[delete_menu_ids]"]').val(removeMenuList.join(','));
            }
        });

    };

    FUNCT.getMenuEvent = () => {
        $(document).on("click", ".menu-model", async function () {
            let _this = $(this);
            let requestData = {
                model: _this.data("model"),
            };

            if(_this.attr('aria-expanded') == 'false') return;
                FUNCT.ajaxGetMenu(requestData);

        });
    };

    FUNCT.ajaxGetMenu = async (requestData) => {
        try {
            let response = await $.ajax({
                type: "GET",
                url: "/ajax/dashboard/getMenu",
                data: requestData,
                dataType: "json",
            });


            if (response.code === 0) {
                let dataArr = response.object.data;
                let menuItem = "";
                $.each(dataArr, function (key, val) {
                    menuItem += `
                        <div class="menu-item">
                            <input ${
                                checkedList.length > 0 &&
                                checkedList.includes(val.canonical)
                                    ? "checked"
                                    : ""
                            } class="menu-checkbox" type="checkbox" value="${
                        val.canonical
                    }" name="" id="${val.canonical}">
                            <label class="ml-10 text-sm text-500 text-success" for="${
                                val.canonical
                            }">${val.name}</label>
                        </div>
                        `;
                });
                $(".menu-list").html(menuItem);

                if (response.object.links.length > 3) {
                    let pagination = FUNCT.menuLinks(response.object.links);
                    $(".menu-list").append(pagination);
                }
            }
        } catch (e) {
            console.log(e);
        }
    };

    FUNCT.ChooseMenuEvent = () => {
        $(document).on("change", ".menu-checkbox", function () {
            let _this = $(this);
            let itemData = {
                canonical: _this.val(),
                name: _this.siblings("label").text(),
            };

            let row = FUNCT.RowMenu(itemData);

            if (_this.is(":checked")) {
                $(".menu-wrapper")
                    .find(".menu_row_notification")
                    .addClass("hidden");
                $(".menu-wrapper").append(row);
                checkedList.push(itemData.canonical);
            } else {
                $(".menu-wrapper")
                    .find(`.menu-row-${itemData.canonical}`)
                    .remove();

                if ($(".menu-row").length === 0) {
                    $(".menu-wrapper")
                        .find(".menu_row_notification")
                        .removeClass("hidden");
                }
                checkedList = checkedList.filter(
                    (item) => item != itemData.canonical
                );
            }
        });
    };

    FUNCT.searchMenuEvent = () => {
        $(document).on("keyup", ".search-menu", function () {
            let _this = $(this);
            let val = _this.val();
            let model = _this.data("model");
            let requestData = {
                model,
                keyword: val,
            };

            clearTimeout(timeoutId);

            timeoutId = setTimeout(() => {
                if (val.length >= 2) {
                    FUNCT.ajaxGetMenu(requestData);
                }
            }, 1000);
        });
    };

    FUNCT.menuLinks = (links) => {
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
                            class="menu-page-link"
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
                            class="menu-page-link"
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
                        <a class="menu-page-link" href="${val.url}">${val.label}</a>
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

    FUNCT.choosePaginateEvent = () => {
        $(document).on("click", ".menu-page-link", function (e) {
            e.preventDefault();
            let _this = $(this);
            let parent = _this.closest(".page-item");
            let model = parent.parents(".panel-collapse").attr("id");
            let page = _this.text();

            if (_this.attr("rel") && _this.attr("rel") == "next") {
                currentPage = parent
                    .siblings(".active")
                    .find(".menu-page-link")
                    .text();
                page = parseInt(currentPage) + 1;
            } else if (_this.attr("rel") && _this.attr("rel") == "prev") {
                currentPage = parent
                    .siblings(".active")
                    .find(".menu-page-link")
                    .text();
                page = parseInt(currentPage) - 1;
            }

            let requestData = {
                page,
                model,
            };

            if (parent.hasClass("active") || parent.hasClass("disabled"))
                return;

            FUNCT.ajaxGetMenu(requestData);
        });
    };

    FUNCT.setupNestable = () => {

        if($("#nestable2").length === 0) {
            return;
        }

        // activate Nestable for list 2
        $("#nestable2")
            .nestable({
                group: 1,
            })
            .on("change", FUNCT.updateOutput);
    };

        FUNCT.updateOutput = (e) => {
            // update the output on change
            let list = e.length ? e : $(e.currentTarget)
            let output = list.data("output");
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable("serialize")));
            } else {
                output.val("JSON browser support required for this demo.");
            }

            // send the serialized data to the server
            let json = window.JSON.stringify(list.nestable("serialize"));
            if(json.length === 0)  return;

            let requestData = {
                json,
                _token,
            };

            $.ajax({
                type: "POST",
                url: "/ajax/menu/dragDrop",
                data: requestData,
                dataType: "json",
                success: function (response) {
                    if (response.code === 0) {
                        console.log("Menu updated successfully.");
                    } else {
                        console.error("Failed to update menu.");
                    }
                },
                error: function (error) {
                    console.error("Error updating menu:", error);
                },
            });
        };

    FUNCT.runUpdateOutput = () => {
            // output initial serialised data
            if($("#nestable2-output").length){
                FUNCT.updateOutput($("#nestable2").data("output", $("#nestable2-output")));
            }
    }

    FUNCT.expandCollapseEvent = () => {
                $("#nestable-menu").on("click", function (e) {
            var target = $(e.target),
                action = target.data("action");
            if (action === "expand-all") {
                $(".dd").nestable("expandAll");
            }
            if (action === "collapse-all") {
                $(".dd").nestable("collapseAll");
            }
        });
    }

    FUNCT.toChildMenuEvent = () => {
        $(document).on("click", ".to-child-menu", function (e) {
            e.stopPropagation();
        });
    }

    $(document).ready(() => {
        FUNCT.createMenuCatalougeEvent();
        FUNCT.addMenuRowEvent();
        FUNCT.deleteMenuRowEvent();
        FUNCT.getMenuEvent();
        FUNCT.ChooseMenuEvent();
        FUNCT.searchMenuEvent();
        FUNCT.choosePaginateEvent();
        FUNCT.setupNestable();
        FUNCT.runUpdateOutput();
        FUNCT.expandCollapseEvent();
        FUNCT.toChildMenuEvent();
    });
})(jQuery);
