(function ($) {
    "use strict";

    let FUNCT = {};
    const _token = $('meta[name="csrf-token"]').attr("content");
    const editBtnTitle = {
        en: "Edit",
        vi: "Chỉnh sửa",
        ja: "編集",
        zh: "编辑",
    };

    const cancelBtnTitle = {
        en: "Cancel",
        vi: "Hủy",
        ja: "キャンセル",
        zh: "取消",
    };

    FUNCT.handleConfirmOrder = () => {
        $(document).on(
            "click",
            ".order-confirm .confirm-right button",
            function () {
                let _this = $(this);
                console.log(_this);
            }
        );
    };

    FUNCT.handleOrderEdit = () => {
        $(document).on("click", ".order-edit", function () {
            let _this = $(this);
            let target = _this.data("target");

            if (!_this.hasClass("open")) {
                _this.addClass("open");
                _this.text(cancelBtnTitle[lang]);
            } else {
                _this.removeClass("open");
                _this.text(editBtnTitle[lang]);
            }

            switch (target) {
                case "orderNote":
                    handleNoteUI();
                    break;

                case "customerInfor":
                    console.log(2);
                    break;
                default:
                    break;
            }
        });
    };

    FUNCT.handleUpdateOrderNote = () => {
        $(document).on("change", 'input[name="order_note_input"]', async function () {
            let _this = $(this);
            let value = _this.val();
            let orderNoteBtn = $('button[data-target="orderNote"]');
            let target = orderNoteBtn.data('target');
            let orderCode = $('input[name="order_code"]').val();
            let noteContent = _this.parents(".ibox-content").find("span");


            let payload = {
                descripion: value,
                code: orderCode,
                target,
                _token,
            };

            let respone = await ajaxUpdateOrder(payload);


            if(respone.code == 0){
                noteContent.text(value);
                _this.addClass('hidden');
                noteContent.removeClass('hidden');
                orderNoteBtn.text(editBtnTitle[lang]);
            }
        });
    };
    $(document).ready(() => {
        FUNCT.handleConfirmOrder();
        FUNCT.handleOrderEdit();
        FUNCT.handleUpdateOrderNote();
    });
})(jQuery);

const handleNoteUI = () => {
    let noteInput = $('input[name="order_note_input"]');

    let noteContent = noteInput.parents(".ibox-content").find("span");
    if (noteInput.hasClass("hidden")) {
        noteInput.text("");
        noteInput.removeClass("hidden");
        noteContent.addClass("hidden");
    } else {
        noteInput.addClass("hidden");
        noteContent.removeClass("hidden");
    }
};

const ajaxUpdateOrder = async (payload) => {
    const respone = await $.ajax({
        type: "POST",
        url: "/ajax/order/ajaxUpdate",
        data: payload,
        dataType: "json",
    });

    return respone;
};
