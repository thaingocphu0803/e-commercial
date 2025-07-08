<?php

return [
    'module' => [
        'postCatalouge' => '投稿グループ',
        'Post' => '投稿',
        'productCatalouge' => '商品グループ',
        'Product' => '商品',
    ],
    'type' => [
        'menu-dropdown' => 'ドロップダウンメニュー',
        'menu-mega' => 'メガメニュー',
    ],
    'effect' => [
        'fade' => 'フェード',
        'cards' => 'カード',
        'cube' => 'キューブ',
        'flip' => 'フリップ',
        'creative' => 'クリエイティブ',
    ],
    'navigate' => [
        'hide' => '非表示',
        'dots' => 'ドット',
        'thumbnails' => 'サムネイル',
    ],
    'promotion' => [
        ['id' => 'order_total_discount', 'name' => '合計金額割引'],
        ['id' => 'product_specific_discount', 'name' => '特定商品割引'],
        ['id' => 'quantity_discount', 'name' => '数量割引'],
        ['id' => 'buy_x_get_discount_y', 'name' => 'X個購入でY割引'],
    ],
    'priceValue' => [
        'vi' => '₫',
        'en' => '$',
        'zh' => '€',
        'ja' => '¥',
    ],
    'productType' => [
        'Product' => '商品バージョン',
        'productCatalouge' => '商品カタログ',
    ],
    'customer' => [
        [
            'id' => 'gender',
            'name' => '性別'
        ],
        [
            'id' => 'birthday',
            'name' => '生年月日'
        ],
        [
            'id' => 'staff',
            'name' => '担当者'
        ],
        [
            'id' => 'cusomer_catalouge',
            'name' => '顧客グループ'
        ]
    ],
    'customer_type' => [
        'gender' => [
            [
                'id' => 1,
                'name' => '男性'
            ],
            [
                'id' => 2,
                'name' => '女性'
            ],
            [
                'id' => 3,
                'name' => 'その他'
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
