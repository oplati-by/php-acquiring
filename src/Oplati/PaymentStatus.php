<?php
declare(strict_types=1);

namespace Oplati\Acquiring;

enum PaymentStatus: int
{
    /**
     *  PaymentStatusInProgress - Платеж ожидает подтверждения, которое должно быть выполнено клиентом
     *  на мобильном устройстве.
     *
     *  Код: IN_PROGRESS
     */
    case PaymentStatusInProgress = 0;

    /**
     *  PaymentStatusDone - Платеж совершен, можно выдать товар клиенту.
     *
     *  Код: OK
     */
    case PaymentStatusDone = 1;

    /**
     *  PaymentStatusDeclined - Отказ от платежа. Клиент не подтвердил платеж.
     *
     *  Код: DECLINE
     */
    case PaymentStatusDeclined = 2;


    /**
     *  PaymentStatusNotEnoughMoney - Недостаточно средств на кошельке клиента.
     *
     *  Код: NOT_ENOUGH
     */
    case PaymentStatusNotEnoughMoney = 3;

    /**
     *  PaymentStatusTimeout - Клиент не подтвердил платеж в течение предопределенного системой Оплати отрезка времени.
     *  Равносильно отказу от оплаты.
     *
     *  Код: TIMEOUT
     */
    case PaymentStatusTimeout = 4;

    /**
     *  PaymentStatusTechCancel - Операция была отменена либо кассой, либо системой, когда не смогла получить информацию
     *  о статусе платежа в течение предопределенного системой Оплати отрезка времени.
     *
     *  Код: TECHNICAL_CANCELLING
     */
    case PaymentStatusTechCancel = 5;

}
