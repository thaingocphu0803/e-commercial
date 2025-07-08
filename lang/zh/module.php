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
        'Product' => '产品版本',
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

];
