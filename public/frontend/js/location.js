(function ($) {
    "use strict";

    var FUNC = {};
    let district_select = $("#district_id");
    
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
                    `<option selected disabled>Choose district</option>`
                );

                ward_select.html(
                    `<option selected disabled>Choose ward</option>`
                );

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
    };

    $(document).ready(() => {
        FUNC.getDistrict();
    });
})(jquery);
