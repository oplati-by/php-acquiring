# Oplati Acquiring PHP Library

PHP библиотека для интеграции с платежной системой Oplati. Позволяет легко интегрировать платежи в ваше PHP приложение.

## Требования

- PHP 8.1 или выше
- Расширение JSON
- Расширение cURL

## Установка

```bash
composer require oplati-by/php-acquiring
```

## Использование

### Инициализация клиента

```php
use Oplati\Acquiring\Client;

$client = new Client(
    'https://oplati-cashboxapi.lwo-dev.by/ms-pay', // URL API
    'OPL000011111',                               // Регистрационный номер кассы
    '11111'                                // Пароль кассы
);
```

### Создание платежа

```php
use Oplati\Acquiring\Dto\Payment;
use Oplati\Acquiring\Dto\PaymentItem;
use Oplati\Acquiring\PaymentItemType;

$payment = new Payment(
    '14092001',                    // Смена (например, дата в формате ДДММГГГГ)
    'AA-1111',                     // Уникальный номер заказа
    [
        new PaymentItem(
            PaymentItemType::PaymentItemTypeService,
            'Консультация продавца',
            499                     // 4.99 BYN (сумма в копейках)
        ),
        new PaymentItem(
            PaymentItemType::PaymentItemTypeProduct,
            'Товар',
            5999                    // 59.99 BYN (сумма в копейках)
        )
    ],
    'Спасибо за покупку!',          // Текст в конце чека
    'https://my.shop.by/success',   // URL для перехода после успешной оплаты
    'https://my.shop.by/failed',    // URL для перехода после неуспешной оплаты
    'https://my.shop.by/webhook'    // URL для уведомлений об оплате
);

try {
    $result = $client->createPayment($payment);
    echo "Платеж создан успешно:\n";
    print_r($result);
} catch (\Oplati\Acquiring\Exception\ServerException $e) {
    echo "Ошибка от сервера Оплати:\n";
    print_r($e->getErrorData());
    echo "\nКод ошибки: " . $e->getCode() . "\n";
}
```

### Получение информации о платеже

```php
$paymentInfo = $client->getPaymentInfo($paymentId);
```

### Отмена платежа

```php
use Oplati\Acquiring\Dto\PaymentRevers;

$reversal = new PaymentRevers(
    '14092001',    // Смена
    'AA-1111',     // Номер заказа
    [              // Список позиций для отмены
        new PaymentItem(
            PaymentItemType::PaymentItemTypeProduct,
            'Товар',
            5999
        )
    ],
    'Отмена заказа' // Текст в конце чека
);

$result = $client->reversePayment($paymentId, $reversal);
```

### Получение списка платежей за смену

```php
$payments = $client->getPaymentsOnShift('14092001');
```

## Типы позиций в чеке

- `PaymentItemType::PaymentItemTypeProduct` (1) - товар
- `PaymentItemType::PaymentItemTypeService` (2) - услуга

## Обработка ошибок

Библиотека использует исключения для обработки ошибок. Основной класс исключений - `Oplati\Acquiring\Exception\ServerException`.

```php
try {
    $result = $client->createPayment($payment);
} catch (\Oplati\Acquiring\Exception\ServerException $e) {
    // Обработка ошибки от сервера Оплати
    $errorData = $e->getErrorData();
    $errorCode = $e->getCode();
} catch (Exception $e) {
    // Обработка других ошибок
}
```

## Логирование

Библиотека предоставляет гибкую систему логирования через интерфейс `LoggerInterface`. По умолчанию используется `FileLogger`, который записывает логи в файл.

### Использование стандартного логгера

```php
use Oplati\Acquiring\Client;

$client = new Client(
    'https://oplati-cashboxapi.lwo-dev.by/ms-pay',
    'OPL000011111',
    '11111'
    // По умолчанию используется FileLogger
);
```

### Использование собственного логгера

```php
use Oplati\Acquiring\Client;
use Oplati\Acquiring\Logger\LoggerInterface;

class CustomLogger implements LoggerInterface
{
    public function logRequest(string $method, string $url, array $headers, ?array $body = null): void
    {
        // Ваша логика логирования запросов
    }

    public function logResponse(string $method, string $url, int $statusCode, ?array $body = null): void
    {
        // Ваша логика логирования ответов
    }

    public function logError(string $method, string $url, string $error, int $code): void
    {
        // Ваша логика логирования ошибок
    }
}

$client = new Client(
    'https://oplati-cashboxapi.lwo-dev.by/ms-pay',
    'OPL000011111',
    '11111',
    new CustomLogger()
);
```

### Настройка FileLogger

```php
use Oplati\Acquiring\Client;
use Oplati\Acquiring\Logger\FileLogger;

$logger = new FileLogger(
    '/path/to/your/log/file.log',  // Путь к файлу лога
    true                           // Форматировать JSON (true) или нет (false)
);

$client = new Client(
    'https://oplati-cashboxapi.lwo-dev.by/ms-pay',
    'OPL000011111',
    '11111',
    $logger
);
```