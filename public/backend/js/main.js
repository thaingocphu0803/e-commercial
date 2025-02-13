let ward_select = $("#ward_id");
let district_select = $("#district_id");


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
        )

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

$(document).on("change", "#district_id", async function () {
    let _this = $(this);

    let district_id = _this.val() ?? districtId;

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

$(() => {
    if (provinceId != "") {
        $("#province_id").val(provinceId).trigger("change");
    }

    if (districtId != "") {
        $("#district_id").val(districtId).trigger("change");
    }
});
