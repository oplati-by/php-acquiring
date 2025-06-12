<?php

declare(strict_types=1);

namespace Oplati\Acquiring\Logger;

interface LoggerInterface
{
    /**
     * Логирует запрос к API
     *
     * @param string $method HTTP метод
     * @param string $url URL запроса
     * @param array $headers Заголовки запроса
     * @param array|null $body Тело запроса
     * @return void
     */
    public function logRequest(string $method, string $url, array $headers, ?array $body = null): void;

    /**
     * Логирует ответ от API
     *
     * @param string $method HTTP метод
     * @param string $url URL запроса
     * @param int $statusCode HTTP статус код
     * @param array|null $body Тело ответа
     * @return void
     */
    public function logResponse(string $method, string $url, int $statusCode, ?array $body = null): void;

    /**
     * Логирует ошибку
     *
     * @param string $method HTTP метод
     * @param string $url URL запроса
     * @param string $error Сообщение об ошибке
     * @param int $code Код ошибки
     * @return void
     */
    public function logError(string $method, string $url, string $error, int $code): void;
} 