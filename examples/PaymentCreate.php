<?php

require_once __DIR__ . '/../vendor/autoload.php';


// Создание платежа
try {
    $client = new \Oplati\Acquiring\Client(
        baseUrl: 'https://oplati-cashboxapi.lwo-dev.by/ms-pay',
        cashboxRegNumber: 'OPL000011111',
        cashboxPassword: '11111'
    );

    $payment = new \Oplati\Acquiring\Dto\Payment(
        shift: '14092001',
        orderNumber: 'AA-1111',
        items: [
            new \Oplati\Acquiring\Dto\PaymentItem(
                type: \Oplati\Acquiring\PaymentItemTypes::PaymentItemTypeService,
                name: 'Консультация продавца',
                cost: 499 // 4.99 BYN
            ),
            new \Oplati\Acquiring\Dto\PaymentItem(
                type: \Oplati\Acquiring\PaymentItemTypes::PaymentItemTypeProduct,
                name: 'Товар',
                cost: 5999 // 59.99 BYN
            )
        ],
        receiptFooterText: 'Спасибо за покупку!',
        successUrl: 'https://my.shop.by/me/orders/AA-1111',
        failureUrl: 'https://my.shop.by/payment-failed',
        notificationUrl: 'https://my.shop.by/api/webhook/orders/AA-1111'
    );

    $result = $client->createPayment($payment);

    print_r($result);

} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage() . "\n";
}