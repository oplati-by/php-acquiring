<?php

try {
    $client = new \Oplati\Acquiring\Client(
        baseUrl: 'https://oplati-cashboxapi.lwo-dev.by/ms-pay',
        cashboxRegNumber: 'OPL000011111',
        cashboxPassword: '11111'
    );

    $payment = new \Oplati\Acquiring\Dto\PaymentRevers(
        shift: '14092001',
        orderNumber: 'AA-1111',
        items: [
            new \Oplati\Acquiring\Dto\PaymentItem(
                type: \Oplati\Acquiring\PaymentItemTypes::PaymentItemTypeProduct,
                name: 'Товар',
                cost: 5999 // 59.99 BYN
            )
        ],
        receiptFooterText: 'Будем рады видеть вас снова!'
    );

    $result = $client->reversePayment($payment, 273121);
} catch (Exception $e) {
    echo $e->getMessage();
}