<?php

namespace Oplati\Acquiring\Dto\Oplati;

class PaymentRequestDetails
{
    private string $regNum;
    /** @var PaymentRequestDetailsItem[] */
    private array $items;
    private float $amountTotal;
    private string $footerInfo;

    public function __construct(
        string $regNum,
        array $items,
        float $amountTotal,
        string $footerInfo
    ) {
        $this->regNum = $regNum;
        $this->items = $items;
        $this->amountTotal = $amountTotal;
        $this->footerInfo = $footerInfo;
    }

    public function toArray(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $item->toArray();
        }

        return [
            'regNum' => $this->regNum,
            'items' => $items,
            'amountTotal' => $this->amountTotal,
            'footerInfo' => $this->footerInfo,
        ];
    }
}