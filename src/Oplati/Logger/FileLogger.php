<?php

declare(strict_types=1);

namespace Oplati\Acquiring\Logger;

class FileLogger implements LoggerInterface
{
    private string $logFile;
    private bool $prettyPrint;

    public function __construct(string $logFile, bool $prettyPrint = true)
    {
        $this->logFile = $logFile;
        $this->prettyPrint = $prettyPrint;
        $this->ensureLogDirectoryExists();
    }

    public function logRequest(string $method, string $url, array $headers, ?array $body = null): void
    {
        $logMessage = $this->formatLogMessage(
            "REQUEST",
            [
                'method' => $method,
                'url' => $url,
                'headers' => $headers,
                'body' => $body
            ]
        );
        $this->writeLog($logMessage);
    }

    public function logResponse(string $method, string $url, int $statusCode, ?array $body = null): void
    {
        $logMessage = $this->formatLogMessage(
            "RESPONSE",
            [
                'method' => $method,
                'url' => $url,
                'statusCode' => $statusCode,
                'body' => $body
            ]
        );
        $this->writeLog($logMessage);
    }

    public function logError(string $method, string $url, string $error, int $code): void
    {
        $logMessage = $this->formatLogMessage(
            "ERROR",
            [
                'method' => $method,
                'url' => $url,
                'error' => $error,
                'code' => $code
            ]
        );
        $this->writeLog($logMessage);
    }

    private function formatLogMessage(string $type, array $data): string
    {
        $timestamp = date('Y-m-d H:i:s');
        $formattedData = $this->prettyPrint 
            ? json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            : json_encode($data, JSON_UNESCAPED_UNICODE);

        return sprintf(
            "======== %s ========\nType: %s\n%s\n=========================\n\n",
            $timestamp,
            $type,
            $formattedData
        );
    }

    private function writeLog(string $message): void
    {
        file_put_contents($this->logFile, $message, FILE_APPEND);
    }

    private function ensureLogDirectoryExists(): void
    {
        $directory = dirname($this->logFile);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }
} 