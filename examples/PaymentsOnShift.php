<?php

try {
    $client = new \Oplati\Acquiring\Client(
        baseUrl: 'https://oplati-cashboxapi.lwo-dev.by/ms-pay',
        cashboxRegNumber: 'OPL000011111',
        cashboxPassword: '11111'
    );
    $result = $client->getPaymentsOnShift(14092001);

    foreach ($result as $payment) {
        switch ($payment['paymentType']) {
            case \Oplati\Acquiring\PaymentTypes::PaymentTypeSell->value :
                echo 'Продажа';
                break;
            case \Oplati\Acquiring\PaymentTypes::PaymentTypeBuy->value:
                echo 'Покупка';
                break;
            case \Oplati\Acquiring\PaymentTypes::PaymentItemTypeSellReverse->value:
                echo 'Возврат продажи (полный или частичный)';
                break;
            case \Oplati\Acquiring\PaymentTypes::PaymentItemTypeBuyReverse->value:
                echo 'Возврат покупки (полный или частичный)';
                break;
        }
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}