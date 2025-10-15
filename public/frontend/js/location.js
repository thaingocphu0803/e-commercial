(function ($) {
    "use strict";

    var FUNC = {};
    let district_select = $("#district_id");
    let ward_select = $("#ward_id");

    let addressSelect = {
        district: {
            vi: "Chọn Quận/Huyện",
            en: "Select District",
            ja: "区／郡を選択",
            zh: "选择区/县",
        },
        ward: {
            vi: "Chọn Phường/Xã",
            en: "Select Ward/Commune",
            ja: "町／村を選択",
            zh: "选择镇/乡",
        },
    };

    FUNC.getDistrict = () => {
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
                    `<option selected disabled>${addressSelect.district[lang]}</option>`
                );

                ward_select.html(
                    `<option selected disabled>${addressSelect.ward[lang]}</option>`
                );

                districts.forEach((district) => {
                    district_select.append(
                        `<option value="${district.code}">${district.name}</option>`
                    );
                });
            } catch (err) {
                console.log(err);
            }
        });
    };

    FUNC.getWard = () => {
        // get ward api
        $(document).on("change", "#district_id", async function () {
            let _this = $(this);
            let district_id = _this.val();
            try {
                const response = await $.ajax({
                    type: "GET",
                    url: "/ajax/location/ward",
                    data: { district_id },
                    dataType: "json",
                });

                ward_select.html(
                    `<option selected disabled>${addressSelect.ward[lang]}</option>`
                );

                response.forEach((ward) => {
                    ward_select.append(
                        `<option value="${ward.code}">${ward.name}</option>`
                    );
                });
            } catch (err) {
                console.log(err);
            }
        });
    };

    $(document).ready(() => {
        FUNC.getDistrict();
        FUNC.getWard();
    });
})(jQuery);
