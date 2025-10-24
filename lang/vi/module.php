<?php

return [
    'module' => [
        'postCatalouge' => 'Nhóm bài viết',
        'Post' => 'Bài viết',
        'productCatalouge' => 'Nhóm sản phẩm',
        'Product' => 'Sản phẩm',
    ],
    'type' => [
        'menu-dropdown' => 'Menu thả xuống',
        'menu-mega' => 'Menu lớn',
    ],
    'effect' => [
        'fade' => 'Mờ dần',
        'cards' => 'Thẻ',
        'cube' => 'Khối lập phương',
        'flip' => 'Lật',
        'creative' => 'Sáng tạo',
    ],
    'navigate' => [
        'hide' => 'Ẩn',
        'dots' => 'Chấm',
        'thumbnails' => 'Hình thu nhỏ',
    ],
    'promotion' => [
        ['id' => 'order_total_discount', 'name' => 'Giảm giá theo tổng đơn'],
        ['id' => 'product_specific_discount', 'name' => 'Giảm giá theo sản phẩm'],
        ['id' => 'quantity_discount', 'name' => 'Giảm giá theo số lượng'],
        ['id' => 'buy_x_get_discount_y', 'name' => 'Mua X giảm Y'],
    ],
    'priceValue' => [
        'vi' => '₫',
        'en' => '$',
        'zh' => '€',
        'ja' => '¥',
    ],
    'productType' => [
        'Product' => 'Phiên bản sản phẩm',
        'productCatalouge' => 'Danh mục sản phẩm',
    ],
    'customer' => [
        [
            'id' => 'gender',
            'name' => 'Giới tính'
        ],
        [
            'id' => 'birthday',
            'name' => 'Ngày sinh'
        ],
        [
            'id' => 'staff',
            'name' => 'Nhân viên phụ trách'
        ],
        [
            'id' => 'cusomer_catalouge',
            'name' => 'Nhóm khách hàng'
        ]
    ],
    'customer_type' => [
        'gender' => [
            [
                'id' => 1,
                'name' => 'Nam'
            ],
            [
                'id' => 2,
                'name' => 'Nữ'
            ],
            [
                'id' => 3,
                'name' => 'Khác'
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
        'price_hl' => 'Giá: cao đến thấp',
        'price_lh' => 'Giá: thấp đến cao',
        'name_az' => 'Tên: A → Z',
        'name_za' => 'Tên: Z → A',
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
        'pending' => 'Chờ xác nhận',
        'confirm' => 'Đã xác nhận',
    ],

    'payment_stt' => [
        'unpaid' => 'Chưa thanh toán',
        'paid' => 'Đã thanh toán',
    ],

    'delivery_stt' => [
        'pending' => 'Chưa giao hàng',
        'delivering' => 'Đang giao hàng',
        'success' => 'Đã giao hàng thành công',
    ],

];
