<?php
declare(strict_types = 1);

namespace Oplati\Acquiring;

use Oplati\Acquiring\Dto\Oplati\PaymentRequest;
use Oplati\Acquiring\Dto\Oplati\PaymentRequestDetails;
use Oplati\Acquiring\Dto\Oplati\PaymentRequestDetailsItem;
use Oplati\Acquiring\Dto\Oplati\PaymentReverse;
use Oplati\Acquiring\Dto\Payment;
use Oplati\Acquiring\Dto\PaymentItem;
use Oplati\Acquiring\Dto\PaymentRevers;

class Convertor
{

    public static function convertPayment(Payment $payment, string $cashboxRegNumber): PaymentRequest
    {

        [$items,$sum] = self::convertPaymentItems($payment->getItems());

        $details = new PaymentRequestDetails(
            regNum: $cashboxRegNumber,
            items: $items,
            amountTotal: $sum,
            footerInfo: $payment->getReceiptFooterText()
        );


       return new PaymentRequest(
            sum: $sum,
            orderNumber: $payment->getOrderNumber(),
            regNum: $cashboxRegNumber,
            details: $details,
            successUrl: $payment->getSuccessUrl(),
            failureUrl: $payment->getFailureUrl(),
            notificationUrl: $payment->getNotificationUrl(),
            shift: $payment->getShift()
        );
    }

    /**
     * @param PaymentItem[] $paymentItems
     * @return array
     */

    private static function convertPaymentItems(array $paymentItems): array
    {
        $sum = 0.0;
        $oplatiPaymentItems = [];
        foreach ($paymentItems as $paymentItem) {
            $paymentRequestDetailItem = new PaymentRequestDetailsItem(
                type: $paymentItem->getType()->value,
                name: $paymentItem->getName(),
                cost: floatval($paymentItem->getCost()) / 100
            );
            $sum += $paymentRequestDetailItem->getCost();
            $oplatiPaymentItems[] = $paymentRequestDetailItem;
        }

        return [$oplatiPaymentItems,  $sum];
    }


    public static function convertReversePayment(PaymentRevers $payment, string $cashboxRegNumber): PaymentReverse
    {
        [$items,$sum] = self::convertPaymentItems($payment->getItems());

        $details = new PaymentRequestDetails(
            regNum: $cashboxRegNumber,
            items: $items,
            amountTotal: $sum,
            footerInfo: $payment->getReceiptFooterText()
        );

        return new PaymentReverse(
            sum: $sum,
            orderNumber: $payment->getOrderNumber(),
            regNum: $cashboxRegNumber,
            details: $details,
            shift: $payment->getShift()
        );

    }
}