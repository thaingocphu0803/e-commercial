'use strict'

var noImage = 'https://res.cloudinary.com/my-could-api/image/upload/v1747992373/no-image_srgttq.svg';


function priceFormat(number) {
    const map = {
        vi: { symbol: '₫', decimals: 0 },
        en: { symbol: '$', decimals: 2 },
        zh: { symbol: '¥', decimals: 0 },
        ja: { symbol: '€', decimals: 2 },
    };

    const { symbol, decimals } = map[lang];

    let num = parseFloat(number) || 0;
4
    let price = num.toLocaleString('en-US', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals,
    });

    return price + symbol;
}

function writeUrl(canonical = '', fullDomain = true, suffix = false) {
    const config = {
        app: {
            url: appUrl,
            general: {
                suffix: ".html"
            }
        }
    };

    if (canonical.startsWith("http")) {
        return canonical;
    }

    const domain = fullDomain ? config.app.url : '';
    const suf = suffix ? config.app.general.suffix : '';

    return domain + "/" + canonical + suf;
}
