<?php

declare(strict_types=1);

namespace Oplati\Acquiring\Exception;

use Exception;
use Throwable;

class ServerException extends Exception
{
    private mixed $errorData;

    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        $this->errorData = json_decode($message, true) ?? ['message' => $message];
        parent::__construct($this->errorData['message'] ?? $message, $code, $previous);
    }

    public function getErrorData(): array
    {
        return $this->errorData;
    }
} 