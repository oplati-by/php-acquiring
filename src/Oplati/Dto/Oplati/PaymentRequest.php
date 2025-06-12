<?php

namespace Oplati\Acquiring\Dto\Oplati;


class PaymentRequest
{
    private ?string $shift;
    private float $sum;
    private string $orderNumber;
    private string $regNum;
    private PaymentRequestDetails $details;
    private string $successUrl;
    private string $failureUrl;
    private string $notificationUrl;

    public function __construct(
        float $sum,
        string $orderNumber,
        string $regNum,
        PaymentRequestDetails $details,
        string $successUrl,
        string $failureUrl,
        string $notificationUrl,
        ?string $shift = null
    ) {
        $this->shift = $shift;
        $this->sum = $sum;
        $this->orderNumber = $orderNumber;
        $this->regNum = $regNum;
        $this->details = $details;
        $this->successUrl = $successUrl;
        $this->failureUrl = $failureUrl;
        $this->notificationUrl = $notificationUrl;
    }

    public function toArray(): array
    {
        return [
            'sum' => $this->sum,
            'orderNumber' => $this->orderNumber,
            'regNum' => $this->regNum,
            'details' => $this->details->toArray(),
            'successUrl' => $this->successUrl,
            'failureUrl' => $this->failureUrl,
            'notificationUrl' => $this->notificationUrl,
            'shift' => $this->shift,
        ];
    }
}