<?php

// Получение информации по номеру платежа
try {
    $client = new \Oplati\Acquiring\Client(
        baseUrl: 'https://oplati-cashboxapi.lwo-dev.by/ms-pay',
        cashboxRegNumber: 'OPL000011111',
        cashboxPassword: '11111'
    );

    $result = $client->getPaymentsOnShift('14092001');

} catch (Exception $e) {
    echo $e->getMessage();
}