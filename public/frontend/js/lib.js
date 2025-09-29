'use strict'

var noImage = 'https://res.cloudinary.com/my-could-api/image/upload/v1747992373/no-image_srgttq.svg';


// const handlePriceFormat = (price) => {

// }



// SELECT
// 	product_variants.id,
// 	product_variants.product_id,
// 	product_variants.album,
// 	product_variants.price,
// 	product_variants.uuid,
// 	p.maxDiscountValue,
// 	p.discountType, p.discountValue,
// 	 product_variants.price - IF( p.maxDiscountValue != 0,
//        LEAST(
//                             CASE
//                                 WHEN p.discountType='amount' THEN p.discountValue
//                                 WHEN p.discountType='percent' THEN product_variants.price * (p.discountValue/100)
//                                 ELSE 0
//                             END,
//                             p.maxDiscountValue
//                         ),
//                         CASE
//                             WHEN p.discountType='amount' THEN p.discountValue
//                             WHEN p.discountType='percent' THEN  product_variants.price * (p.discountValue/100)
//                             ELSE 0
//                         END
//                     ) as discounted_price

// from
// 	product_variants
// LEFT JOIN
// 	promotion_product_variant as ppv ON ppv.variant_uuid = product_variants.uuid
// LEFT JOIN
// 	promotions as p ON ppv.promotion_id = p.id AND p.publish = 1
// WHERE
// 	product_variants.publish = 1
// AND
// 	product_variants.code ='3-4'
// AND
// 	product_variants.product_id = 42
// ORDER BY discounted_price desc
// LIMIT 1
