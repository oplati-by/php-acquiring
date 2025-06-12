<?php

namespace Oplati\Acquiring\Dto\Oplati;

class PaymentRequestDetailsItem
{
    private int $type;
    private string $name;
    private float $cost;

    public function __construct(int $type, string $name, float $cost)
    {
        $this->type = $type;
        $this->name = $name;
        $this->cost = $cost;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'cost' => $this->cost,
        ];
    }
}