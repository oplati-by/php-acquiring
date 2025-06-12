<?php
declare(strict_types = 1);

namespace Oplati\Acquiring\Dto;

class PaymentRevers
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


    public function __construct(string $shift, string $orderNumber, array $items, ?string $receiptFooterText)
    {
        $this->shift = $shift;
        $this->orderNumber = $orderNumber;
        $this->items = $items;
        $this->receiptFooterText = $receiptFooterText;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getReceiptFooterText(): ?string
    {
        return $this->receiptFooterText;
    }
    public function getShift(): string
    {
        return $this->shift;
    }
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

}