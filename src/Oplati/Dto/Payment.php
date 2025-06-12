<?php

declare(strict_types=1);

namespace Oplati\Acquiring\Dto;

class Payment
{
    /**
     * @var $shift string   Смена. Например дата в формате ДДММГГГГ
     */
    private string $shift;

    /**
     * @var string  Уникальный номер заказа
     */
    private string $orderNumber;

    /**
     * @var PaymentItem[]  Список позиций в чеке
     */
    private array $items;

    /**
     * @var string|null Дополнительная информация в конце чека
     */
    private ?string $receiptFooterText;

    /**
     * @var string|null URL для перехода после успешной оплаты
     */
    private ?string $successUrl;

    /**
     * @var string|null URL для перехода после неуспешной оплаты
     */
    private ?string $failureUrl;

    /**
     * @var string|null URL для отправки уведомления об оплате со стороны Оплати
     */
    private ?string $notificationUrl;


    /**
     * @param PaymentItem[] $items
     */
    public function __construct(
        string  $shift,
        string  $orderNumber,
        array   $items,
        ?string $receiptFooterText = null,
        ?string $successUrl = null,
        ?string $failureUrl = null,
        ?string $notificationUrl = null
    )
    {
        $this->shift = $shift;
        $this->orderNumber = $orderNumber;
        $this->items = $items;
        $this->receiptFooterText = $receiptFooterText;
        $this->successUrl = $successUrl;
        $this->failureUrl = $failureUrl;
        $this->notificationUrl = $notificationUrl;
    }

    public function getShift(): string
    {
        return $this->shift;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @return PaymentItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getReceiptFooterText(): ?string
    {
        return $this->receiptFooterText;
    }

    public function getSuccessUrl(): ?string
    {
        return $this->successUrl;
    }

    public function getFailureUrl(): ?string
    {
        return $this->failureUrl;
    }

    public function getNotificationUrl(): ?string
    {
        return $this->notificationUrl;
    }

    public function toArray(): array
    {
        return [
            'shift' => $this->shift,
            'orderNumber' => $this->orderNumber,
            'items' => array_map(function (PaymentItem $item) {
                return $item->toArray();
            }, $this->items),
            'receiptFooterText' => $this->receiptFooterText,
            'successUrl' => $this->successUrl,
            'failureUrl' => $this->failureUrl,
            'notificationUrl' => $this->notificationUrl,
        ];
    }
} 