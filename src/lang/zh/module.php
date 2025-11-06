<?php

return [
    'module' => [
        'postCatalouge' => '文章组',
        'Post' => '文章',
        'productCatalouge' => '产品组',
        'Product' => '产品',
    ],
    'type' => [
        'menu-dropdown' => '下拉菜单',
        'menu-mega' => '大型菜单',
    ],
    'effect' => [
        'fade' => '淡入淡出',
        'cards' => '卡片',
        'cube' => '立方体',
        'flip' => '翻转',
        'creative' => '创意',
    ],
    'navigate' => [
        'hide' => '隐藏',
        'dots' => '点',
        'thumbnails' => '缩略图',
    ],
    'promotion' => [
        ['id' => 'order_total_discount', 'name' => '订单总额折扣'],
        ['id' => 'product_specific_discount', 'name' => '特定产品折扣'],
        ['id' => 'quantity_discount', 'name' => '数量折扣'],
        ['id' => 'buy_x_get_discount_y', 'name' => '买X减Y'],
    ],
    'priceValue' => [
        'vi' => '₫',
        'en' => '$',
        'zh' => '€',
        'ja' => '¥',
    ],
    'productType' => [
        'product' => '产品版本',
        'productCatalouge' => '产品目录',
    ],
    'customer' => [
        [
            'id' => 'gender',
            'name' => '性别'
        ],
        [
            'id' => 'birthday',
            'name' => '生日'
        ],
        [
            'id' => 'staff',
            'name' => '负责人'
        ],
        [
            'id' => 'cusomer_catalouge',
            'name' => '客户分类'
        ]
    ],
    'customer_type' => [
        'gender' => [
            [
                'id' => 1,
                'name' => '男'
            ],
            [
                'id' => 2,
                'name' => '女'
            ],
            [
                'id' => 3,
                'name' => '其他'
            ]
        ],
        'birthday' => array_map(function ($num) {
            return [
                'id' => $num - 1,
                'name' => $num
            ];
        }, range(1, 30))
    ],
    'sort_by' => [
        'price_hl' => '价格：从高到低',
        'price_lh' => '价格：从低到高',
        'name_az' => '名称：A → Z',
        'name_za' => '名称：Z → A',
    ],

    'payment' => [
        [
            'id' => 'cod',
            'img' => asset('frontend/imgs/payment/cod.webp'),
            'title' => 'custom.payByCOD'
        ],
        [
            'id' => 'zalopay',
            'img' => asset('frontend/imgs/payment/zalopay.webp'),
            'title' => 'custom.payByZalo'
        ],
        [
            'id' => 'momo',
            'img' => asset('frontend/imgs/payment/momo.webp'),
            'title' => 'custom.payByMomo'
        ],
        [
            'id' => 'shopee',
            'img' => asset('frontend/imgs/payment/shopeepay.webp'),
            'title' => 'custom.payByShopee'
        ],
        [
            'id' => 'vnpay',
            'img' => asset('frontend/imgs/payment/vnpay.webp'),
            'title' => 'custom.payByVNP'
        ],
    ],

    'confirm_stt' => [
        'pending' => '待确认',
        'confirm' => '已确认',
    ],

    'payment_stt' => [
        'unpaid' => '未付款',
        'paid' => '已付款',
    ],

    'delivery_stt' => [
        'pending' => '待发货',
        'delivering' => '配送中',
        'success' => '已送达',
    ],

];
