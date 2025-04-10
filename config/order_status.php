<?php

return [

    'flow' => [
        'pending' => ['confirmed'],
        'confirmed' => ['preparing'],
        'preparing' => ['handed_over'],
        'handed_over' => ['shipping'],
        'shipping' => ['completed'],
        'completed' => ['return_processing'],
        'return_processing' => ['shop_refunded'],
        'shop_refunded' => ['customer_confirmed_refund'],
        'customer_confirmed_refund' => ['refunded'],
        'refunded' => [],
        'cancelled' => [],
        'failed' => [],
    ],

    'labels' => [
        'pending' => 'Chờ xử lý',
        'confirmed' => 'Đã xác nhận',
        'preparing' => 'Đang chuẩn bị hàng',
        'handed_over' => 'Đã bàn giao cho vận chuyển',
        'shipping' => 'Đang vận chuyển',
        'completed' => 'Giao hàng thành công',
        'return_processing' => 'Đang xử lý trả hàng hoàn tiền',
        'shop_refunded' => 'Shop đã hoàn tiền',
        'customer_confirmed_refund' => 'Khách xác nhận đã nhận tiền',
        'refunded' => 'Đã hoàn tiền',
        'cancelled' => 'Đã hủy',
        'failed' => 'Thất bại',
    ],

    'colors' => [
        'pending' => 'warning',
        'confirmed' => 'info',
        'preparing' => 'primary',
        'handed_over' => 'dark',
        'shipping' => 'primary',
        'completed' => 'success',
        'return_processing' => 'warning',
        'shop_refunded' => 'info',
        'customer_confirmed_refund' => 'success',
        'refunded' => 'secondary',
        'cancelled' => 'danger',
        'failed' => 'danger',
    ],

    'icons' => [
        'pending' => 'bi-hourglass-split',
        'confirmed' => 'bi-check-circle',
        'preparing' => 'bi-box-seam',
        'handed_over' => 'bi-truck',
        'shipping' => 'bi-truck',
        'completed' => 'bi-check2-circle',
        'return_processing' => 'bi-arrow-clockwise',
        'shop_refunded' => 'bi-cash-coin',
        'customer_confirmed_refund' => 'bi-person-check',
        'refunded' => 'bi-arrow-counterclockwise',
        'cancelled' => 'bi-x-circle',
        'failed' => 'bi-exclamation-triangle',
    ],
];
