<?php
declare(strict_types=1);

namespace Oplati\Acquiring;

enum PaymentItemTypes: int
{
    // PaymentItemTypeProduct - товар
    case PaymentItemTypeProduct = 1;
    // PaymentItemTypeService - услуга
    case PaymentItemTypeService = 2;
} 