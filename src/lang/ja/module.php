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
        'product' => '商品バージョン',
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
    'sort_by' => [
        'price_hl' => '価格：高い順',
        'price_lh' => '価格：安い順',
        'name_az' => '名前：A → Z',
        'name_za' => '名前：Z → A',
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
        'pending' => '確認待ち',
        'confirm' => '確認済み',
        'cancel' => 'キャンセル'
    ],

    'payment_stt' => [
        'unpaid' => '未払い',
        'paid' => '支払い完了',
    ],

    'delivery_stt' => [
        'pending' => '配送準備中',
        'delivering' => '配送中',
        'success' => '配送完了',
    ],

];
