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

    FUNCT.handleConfirmOrder = () => {
        $(document).on("click", ".order-confirm-btn", async function () {
            let _this = $(this);
            let orderCanelBtn = $(".order-cancel-btn");
            let orderAlert = $(".order-alert");
            let confirm = _this.data("confirm");

            let payload = {
                code: orderCode,
                confirm,
                _token,
            };

            const AlertConfirmed = {
                en: `The ${orderPrice} order has been confirmed.`,
                vi: `Đơn hàng trị giá ${orderPrice} đã được xác nhận.`,
                ja: `${orderPrice} のご注文が確認されました。`,
                zh: `金额为 ${orderPrice} 的订单已确认。`,
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
                let noteContent = _this.parents(".ibox-content").find("span");

                let payload = {
                    description: value,
                    code: orderCode,
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
            let payload = {
                fullname: $('input[name="customer_infor_name"]').val(),
                email: $('input[name="customer_infor_email"]').val(),
                phone: $('input[name="customer_infor_phone"]').val(),
                address: $('input[name="customer_infor_address"]').val(),
                province_id: $('select[name="province_id"]').val(),
                district_id: $('select[name="district_id"]').val(),
                ward_id: $('select[name="ward_id"]').val(),
                code: orderCode,
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
            let confirm = _this.data("confirm");

            let payload = {
                code: orderCode,
                confirm,
                _token,
            };

            const AlertCancel = {
                en: `The ${orderPrice} order has been cancelled.`,
                vi: `Đơn hàng trị giá ${orderPrice} đã bị hủy.`,
                ja: `${orderPrice} のご注文はキャンセルされました。`,
                zh: `金额为 ${orderPrice} 的订单已被取消。`,
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

    FUNCT.handleOrderStatus = () => {
        $(document).on("change", ".select-orders-stt", async function () {
            let _this = $(this);
            let code = _this.data("code");
            let field = _this.data("field");
            let value = _this.val();
            let oldValue = _this.data("old");

            let payload = {
                [field]: value,
                code,
                _token,
            };

            let respone = await ajaxUpdateOrder(payload);

            if (respone.code == 0) {
                toastr.clear();
                toastr.success(respone.message, toastTitle[lang]);
            } else {
                _this.val(oldValue).trigger("change.select2");
                toastr.clear();
                toastr.error(respone.message, toastTitle[lang]);
            }
        });
    };

    FUNCT.changeStatusAllOrder = () => {
        $(document).on("click", ".changeStatusAllOrder", async function (e) {
            e.preventDefault();
            let _this = $(this);
            let ids = [];
            let value =  _this.attr("data-value");
            let model = _this.attr("data-model");
            let field = _this.attr("data-field");

            let successMessage = {
                en: "Update all order status success",
                vi: "Cập nhật trạng thái tất cả đơn hàng thành công",
                ja: "すべての注文ステータスを更新しました",
                zh: "成功更新所有订单状态",
            };

            let failedMessage = {
                en: "Failed to update order status",
                vi: "Cập nhật trạng thái đơn hàng thất bại",
                ja: "注文ステータスの更新に失敗しました",
                zh: "更新订单状态失败",
            };

            $(".checkItem:checked").each(function () {
                let checkItem = $(this);
                ids.push(checkItem.val());
            });

            if (!ids.length) return;

            let requestData = {
                value,
                ids,
                model,
                field,
                _token: _token,
            };

            const response = await $.ajax({
                type: "POST",
                url: "/ajax/dashboard/changeStatusAll",
                data: requestData,
                dataType: "json",
            });

            if (response.flag) {
                $(".checkItem:checked").each(function () {
                    let _this = $(this);
                    let selectElement = _this.parents('tr').find(`select[data-field="${field}"]`);
                    selectElement.val(value).trigger('change.select2');
                });

                toastr.clear();
                toastr.success(successMessage[lang], toastTitle[lang]);
            } else {
                toastr.clear();
                toastr.error(failedMessage[lang], toastTitle[lang]);
            }
        });
    };

    $(document).ready(() => {
        FUNCT.handleConfirmOrder();
        FUNCT.handleOrderEdit();
        FUNCT.handleUpdateOrderNote();
        FUNCT.handleSaveCustomerInfor();
        FUNCT.handleCancelOrder();
        FUNCT.handleOrderStatus();
        FUNCT.changeStatusAllOrder();
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
