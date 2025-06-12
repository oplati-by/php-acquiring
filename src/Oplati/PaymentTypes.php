<?php
declare(strict_types=1);

namespace Oplati\Acquiring;

enum PaymentTypes: int
{
    // PaymentTypeSell - Продажа (приходная кассовая операция)
    case PaymentTypeSell = 1;
    // PaymentTypeBuy - Покупка (расходная кассовая операция)
    case PaymentTypeBuy = 2;
    // PaymentItemTypeSellReverse - Возврат продажи (расходная кассовая операция)
    case PaymentItemTypeSellReverse = 3;
    // PaymentItemTypeBuyReverse - Возврат покупки (приходная кассовая операция)
    case PaymentItemTypeBuyReverse = 4;

}
