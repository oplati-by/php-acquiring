<?php

declare(strict_types=1);

namespace Oplati\Acquiring\Dto;

use Oplati\Acquiring\PaymentItemTypes;

class PaymentItem
{
    private PaymentItemTypes $type;
    private string $name;
    private int $cost;

    public function __construct(PaymentItemTypes $type, string $name, int $cost)
    {
        $this->type = $type;
        $this->name = $name;
        $this->cost = $cost;
    }

    public function getType(): PaymentItemTypes
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'name' => $this->name,
            'cost' => $this->cost,
        ];
    }
} 