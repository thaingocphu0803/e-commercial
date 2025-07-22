<?php

return [
    //2025/06/05
    'module' =>  [
        'postCatalouge' => 'Post Group',
        'Post' => 'Posts',
        'productCatalouge' => 'Product Group',
        'Product' => 'Products',
    ],
    'type' => [
        'menu-dropdown' => 'Menu Dropdown',
        'menu-mega' => 'Menu Mega'
    ],
    'effect' => [
        'fade' => 'Fade',
        'cards' => 'Cards',
        'cube' => 'Cube',
        'flip' => 'Flip',
        'creative' => 'Creative'
    ],
    'navigate' => [
        'hide' => 'hidden',
        'dots' => 'Dot',
        'thumbnails' => 'Thumbnails'
    ],
    'promotion' => [
        [
            'id' => 'order_total_discount',
            'name' => 'Order Total Discount'
        ],
        [
            'id' => 'product_specific_discount',
            'name' => 'Product Specific Discount'
        ],
        [
            'id' => 'quantity_discount',
            'name' => 'Quantity Discount'
        ],
        [
            'id' => 'buy_x_get_discount_y',
            'name' => 'Buy X Get Y Discount'
        ],
    ],
    'priceValue' => [
        'vi' => '₫',
        'en' => '$',
        'zh' => '€',
        'ja' => '¥',
    ],
    'productType' => [
        'Product' => 'Product Version',
        'productCatalouge' => 'Product catalouge',

    ],
    //2025/07/16
    'customer' => [
        [
            'id' => 'gender',
            'name' =>  'Gender'
        ],
        [
            'id' => 'birthday',
            'name' =>  'Birthday'
        ],
        [
            'id' => 'staff',
            'name' =>  'Staff'
        ],
        [
            'id' => 'cusomer_catalouge',
            'name' =>  'Customer catalouge'
        ]
    ],
    'customer_type' => [
        'gender' => [
            [
                'id' => 1,
                'name' =>  'Male'
            ],
            [
                'id' => 2,
                'name' =>  'Female'
            ],
            [
                'id' => 3,
                'name' =>  'Other'
            ]
        ],
        'birthday' => array_map(function ($num) {
            return [
                'id' => $num - 1,
                'name' => $num
            ];
        }, range(1, 30))
    ],
];
