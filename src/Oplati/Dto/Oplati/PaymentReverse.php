<?php

namespace Oplati\Acquiring\Dto\Oplati;


class PaymentReverse
{
    private ?string $shift;
    private float $sum;
    private string $orderNumber;
    private string $regNum;
    private PaymentRequestDetails $details;

    public function __construct(float $sum,string $orderNumber,string $regNum, PaymentRequestDetails $details,?string $shift)
    {
        $this->sum = $sum;
        $this->orderNumber = $orderNumber;
        $this->regNum = $regNum;
        $this->details = $details;
        $this->shift = $shift;
    }

    public function toArray(): array
    {
        return [
            'sum' => $this->sum,
            'orderNumber' => $this->orderNumber,
            'regNum' => $this->regNum,
            'details' => $this->details->toArray(),
            'shift' => $this->shift,
        ];
    }
}