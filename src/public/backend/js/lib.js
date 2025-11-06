'use trict';

const convertToFloat = (value) => {
    const strValue = String(value);
    const rawValue = strValue.replace(/,/g, "");
    const num = parseFloat(rawValue);
    return num;
};

const convertToCommas = (value) => {
    let StrValue = String(value);
    let num = StrValue.replace(/[^0-9.]/g, "");
    // Ensure only one decimal point is allowed
    const parts = num.split(",");
    if (parts.length > 2) {
        num = parts[0] + "," + parts.slice(1).join("");
    }

    // Format the num with commas as thousand separators
    num = num.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num;
};
