<?php
declare(strict_types=1);

namespace Oplati\Acquiring;

use Oplati\Acquiring\Dto\Oplati\PaymentRequest;
use Oplati\Acquiring\Dto\Payment;
use Oplati\Acquiring\Dto\PaymentRevers;
use Oplati\Acquiring\Exception\ServerException;
use Oplati\Acquiring\Logger\LoggerInterface;
use Oplati\Acquiring\Logger\FileLogger;

class Client
{
    private string $baseUrl;
    private string $cashboxRegNumber;
    private string $cashboxPassword;
    private LoggerInterface $logger;

    public function __construct(
        string $baseUrl, 
        string $cashboxRegNumber, 
        string $cashboxPassword,
        ?LoggerInterface $logger = null
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->cashboxRegNumber = $cashboxRegNumber;
        $this->cashboxPassword = $cashboxPassword;
        $this->logger = $logger ?? new FileLogger(__DIR__ . '/../../log/oplati_requests.log');
    }

    private function sendRequest(string $method, string $endpoint, array $data = null): array
    {
        $curl = curl_init();
        $url = $this->baseUrl . $endpoint;
        
        $headers = [
            'RegNum: ' . $this->cashboxRegNumber,
            'Password: ' . $this->cashboxPassword,
            'Content-Type: application/json',
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => $method,
        ];

        if ($data !== null) {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        $this->logger->logRequest($method, $url, $headers, $data);

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        
        curl_close($curl);

        if ($error) {
            $this->logger->logError($method, $url, $error, 0);
            throw new ServerException($error, 0);
        }

        $responseData = json_decode($response, true);
        $this->logger->logResponse($method, $url, $statusCode, $responseData);

        if ($statusCode >= 400) {
            $this->logger->logError($method, $url, $response, $statusCode);
            throw new ServerException($response, $statusCode);
        }

        return $responseData;
    }

    /**
     * createPayment - создание платежа на стороне Оплати. Возвращает уникальный номер платежа в системе Оплати и URL для
     * выполнения оплаты. Используется запрос POST /pos/webPayments/v2.
     *
     * @throws ServerException
     */
    public function createPayment(Payment $payment): array
    {
        $oplatiPayment = \Oplati\Acquiring\Convertor::convertPayment($payment, $this->cashboxRegNumber);
        return $this->sendRequest('POST', '/pos/webPayments/v2', $oplatiPayment->toArray());
    }

    /**
     *  getPaymentInfo - Получение информации о платеже в системе Оплати. Используется запрос GET /pos/payments/{paymentId}.
     *
     * @throws ServerException
     */
    public function getPaymentInfo(int $paymentId): array
    {
        return $this->sendRequest('GET', "/pos/payments/{$paymentId}");
    }

    /**
     * reversePayment - Выполнение отмены (полной или частичной) любой операции, выполненной в течение периода
     * предопределенного системой Оплати. Используется запрос POST /pos/payments/{paymentId}/reversals.
     *
     * @throws ServerException
     */
    public function reversePayment( PaymentRevers $reversal,int $paymentId): array
    {
        $oplatiPaymentReversal = \Oplati\Acquiring\Convertor::convertReversePayment($reversal, $this->cashboxRegNumber);

        return $this->sendRequest('POST', "/pos/payments/{$paymentId}/reversals", $oplatiPaymentReversal->toArray());
    }

    /**
     * getPaymentsOnShift - Получение списка платежей для сверки итогов по смене. Используется запрос GET /pos/paymentReports.
     * @throws ServerException
     */
    public function getPaymentsOnShift(string $shift): array
    {
        return $this->sendRequest('GET', "/pos/paymentReports?shift=" . $shift);
    }

} 