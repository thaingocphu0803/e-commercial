(function ($) {
    "use strict";

    let FUNCT = {};
    const _token = $('meta[name="csrf-token"]').attr("content");
    const orderCode = $('input[name="order_code"]').val();

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

    const toastTitle = {
        vi: "Hệ thống",
        en: "System",
        zh: "系统",
        ja: "システム",
    };

    const messageConfirmed = {
        en: "confirmed",
        vi: "đã xác nhận",
        ja: "確認済み",
        zh: "已確認",
    };

    const messageCancelled = {
        en: "cancelled",
        vi: "đã hủy",
        ja: "キャンセル済み",
        zh: "已取消",
    };

    if (typeof orderPrice !== "undefined") {
        const AlertConfirmed = {
            en: `The ${orderPrice} order has been confirmed.`,
            vi: `Đơn hàng trị giá ${orderPrice} đã được xác nhận.`,
            ja: `${orderPrice} のご注文が確認されました。`,
            zh: `金额为 ${orderPrice} 的订单已确认。`,
        };

        const AlertCancel = {
            en: `The ${orderPrice} order has been cancelled.`,
            vi: `Đơn hàng trị giá ${orderPrice} đã bị hủy.`,
            ja: `${orderPrice} のご注文はキャンセルされました。`,
            zh: `金额为 ${orderPrice} 的订单已被取消。`,
        };
    }

    FUNCT.handleConfirmOrder = () => {
        $(document).on("click", ".order-confirm-btn", async function () {
            let _this = $(this);
            let orderCanelBtn = $(".order-cancel-btn");
            let orderAlert = $(".order-alert");
            let target = _this.data("target");
            let confirm = _this.data("confirm");
            let payload = {
                code: orderCode,
                confirm,
                target,
                _token,
            };

            let respone = await ajaxUpdateOrder(payload);

            if (respone.code == 0) {
                let spanElement = $("<span>")
                    .addClass("text-sm text-muted text-capitalize")
                    .text(messageConfirmed[lang]);
                _this.parents(".confirm-right").html(spanElement);
                orderAlert.find(".alert-icon img").attr("src", successIcon);
                orderAlert
                    .find(".alert-body .alert-title")
                    .text(AlertConfirmed[lang]);
                orderCanelBtn.removeClass("hidden");
                toastr.clear();
                toastr.success(respone.message, toastTitle[lang]);
            } else {
                toastr.clear();
                toastr.error(respone.message, toastTitle[lang]);
            }
        });
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
                    handleCustomerInforUI();
                    break;
                default:
                    break;
            }
        });
    };

    FUNCT.handleUpdateOrderNote = () => {
        $(document).on(
            "change",
            'input[name="order_note_input"]',
            async function () {
                let _this = $(this);
                let value = _this.val();
                let orderNoteBtn = $('button[data-target="orderNote"]');
                let target = orderNoteBtn.data("target");
                let noteContent = _this.parents(".ibox-content").find("span");

                let payload = {
                    description: value,
                    code: orderCode,
                    target,
                    _token,
                };

                let respone = await ajaxUpdateOrder(payload);

                if (respone.code == 0) {
                    noteContent.text(value);
                    _this.addClass("hidden");
                    noteContent.removeClass("hidden");
                    orderNoteBtn.text(editBtnTitle[lang]);
                    orderNoteBtn.removeClass("open");
                    toastr.clear();
                    toastr.success(respone.message, toastTitle[lang]);
                } else {
                    toastr.clear();
                    toastr.error(respone.message, toastTitle[lang]);
                }
            }
        );
    };

    FUNCT.handleSaveCustomerInfor = () => {
        $(document).on("click", "#save_customer_infor", async function () {
            let staticCustomerBox = $(".static-customer-box");
            let editCustomerBox = $(".edit-customer-box");
            let orderNoteBtn = $('button[data-target="customerInfor"]');
            let target = orderNoteBtn.data("target");
            let payload = {
                fullname: $('input[name="customer_infor_name"]').val(),
                email: $('input[name="customer_infor_email"]').val(),
                phone: $('input[name="customer_infor_phone"]').val(),
                address: $('input[name="customer_infor_address"]').val(),
                province_id: $('select[name="province_id"]').val(),
                district_id: $('select[name="district_id"]').val(),
                ward_id: $('select[name="ward_id"]').val(),
                code: orderCode,
                target,
                _token,
            };

            let respone = await ajaxUpdateOrder(payload);

            if (respone.code == 0) {
                orderNoteBtn.text(editBtnTitle[lang]);
                orderNoteBtn.removeClass("open");

                editCustomerBox.addClass("hidden");
                staticCustomerBox.removeClass("hidden");
                // update static customer box
                FUNCT.updateStaticCustomerBox(staticCustomerBox, payload);
                toastr.clear();
                toastr.success(respone.message, toastTitle[lang]);
            } else {
                toastr.clear();
                toastr.error(respone.message, toastTitle[lang]);
            }
        });
    };

    FUNCT.updateStaticCustomerBox = (staticCustomerBox, payload) => {
        let provinceName = $(
            'select[name="province_id"] option:selected'
        ).text();
        let districtName = $(
            'select[name="district_id"] option:selected'
        ).text();
        let wardName = $('select[name="ward_id"] option:selected').text();

        staticCustomerBox.find(".customer-name").text(payload.fullname);
        staticCustomerBox.find(".customer-email").text(payload.email);
        staticCustomerBox.find(".customer-phone").text(payload.phone);
        staticCustomerBox.find(".customer-address").text(payload.address);
        staticCustomerBox.find(".customer-ward").text(wardName);
        staticCustomerBox.find(".customer-district").text(districtName);
        staticCustomerBox.find(".customer-province").text(provinceName);
    };

    FUNCT.handleCancelOrder = () => {
        $(document).on("click", ".order-cancel-btn", async function () {
            let _this = $(this);
            let parent = _this.parents(".order-alert");
            let target = _this.data("target");
            let confirm = _this.data("confirm");
            let payload = {
                code: orderCode,
                confirm,
                target,
                _token,
            };

            let respone = await ajaxUpdateOrder(payload);

            if (respone.code == 0) {
                let spanElement = $("<span>")
                    .addClass("text-sm text-muted text-capitalize")
                    .text(messageCancelled[lang]);
                parent.find(".alert-body .alert-title").text(AlertCancel[lang]);
                parent.find(".alert-cancel").html(spanElement);
                toastr.clear();
                toastr.success(respone.message, toastTitle[lang]);
            } else {
                toastr.clear();
                toastr.error(respone.message, toastTitle[lang]);
            }
        });
    };

    $(document).ready(() => {
        FUNCT.handleConfirmOrder();
        FUNCT.handleOrderEdit();
        FUNCT.handleUpdateOrderNote();
        FUNCT.handleSaveCustomerInfor();
        FUNCT.handleCancelOrder();
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

const handleCustomerInforUI = () => {
    let staticCustomerBox = $(".static-customer-box");
    let editCustomerBox = $(".edit-customer-box");
    if (staticCustomerBox.hasClass("hidden")) {
        staticCustomerBox.removeClass("hidden");
        editCustomerBox.addClass("hidden");
    } else {
        staticCustomerBox.addClass("hidden");
        editCustomerBox.removeClass("hidden");
        $(".select2").select2();
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
