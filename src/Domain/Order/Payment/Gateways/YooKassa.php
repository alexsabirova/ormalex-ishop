<?php

declare(strict_types=1);

namespace Domain\Order\Payment\Gateways;

use Domain\Order\Contracts\PaymentGatewayContract;
use Domain\Order\Exceptions\PaymentProviderException;
use Domain\Order\Payment\PaymentData;
use Exception;
use Illuminate\Http\JsonResponse;
use Support\ValueObjects\Price;
use Throwable;

class YooKassa implements PaymentGatewayContract
{
    protected Client $client;

    protected PaymentData $paymentData;

    protected string $errorMessage;

    public function __construct(array $config)
    {
        $this->client = new Client();

        $this->configure($config);
    }

    public function paymentId(): string
    {
        return $this->paymentData->id;
    }

    public function configure(array $config): void
    {
        $this->client->setAuth(...$config);
    }

    public function data(PaymentData $data): PaymentGatewayContract
    {
        $this->paymentData = $data;

        return $this;
    }

    public function request(): mixed
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    /**
     * @throws PaymentProviderException
     */
    public function response(): JsonResponse
    {
        try {
            $response = $this->client
                ->capturePayment(
                    $this->payload(),
                    $this->paymentObject()->getId(),
                    $this->idempotenceKey()
                );
        } catch (Throwable $e) {
            $this->errorMessage = $e->getMessage();

            throw new PaymentProviderException($e->getMessage());
        }

        return response()->json($response);
    }

    /**
     * @throws PaymentProviderException
     */
    public function url(): string
    {
        try {
            $response = $this->client->createPayment(
                $this->payload(),
                $this->idempotenceKey()
            );

            return $response
                ->getConfirmation()
                ->getConfirmationUrl();

        } catch (Throwable $e) {
            throw new PaymentProviderException($e->getMessage());
        }
    }

    /**
     * @throws PaymentProviderException
     */
    public function validate(): bool
    {
        $meta = $this->paymentObject()->getMetadata()->toArray();

        $this->data(new PaymentData(
            $this->paymentObject()->getId(),
            $this->paymentObject()->getDescription(),
            '',
            Price::make(
                $this->paymentObject()->getAmount()->getIntegerValue(),
                $this->paymentObject()->getAmount()->getCurrency(),
            ),

            collect($meta)
        ));

        return $this->paymentObject()->getStatus() === PaymentStatus::WAITING_FOR_CAPTURE;
    }

    /**
     * @throws PaymentProviderException
     */
    public function paid(): bool
    {
        return $this->paymentObject()->getPaid();
    }

    public function errorMessage(): string
    {
        return $this->errorMessage;
    }

    private function payload(): array
    {
        return [
            'amount' => [
                'value' => $this->paymentData->amount->value(),
                'currency' => $this->paymentData->amount->currency(),
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => $this->paymentData->returnUrl,
            ],
            'metadata' => $this->paymentData->meta->toArray(),
            'receipt' => [
                'customer' => [
                    'full_name' => 'Ivanov Ivan Ivanovich',
                    'email' => 'email@email.ru',
                    'phone' => '79211234567',
                    'inn' => '6321341814'
                ],
                'items' => [
                    [
                        'description' => $this->paymentData->description,
                        'quantity' => '1.00',
                        'amount' => [
                            'value' => $this->paymentData->amount->value(),
                            'currency' => $this->paymentData->amount->currency(),
                        ],
                        'vat_code' => '1',
                        'tax_system_code' => '1',
                        'payment_mode' => 'full_payment',
                        'payment_subject' => 'commodity',
                        'product_code' => '44 4D 01 00 21 FA 41 00 23 05 41 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 12 00 AB 00',
                        'customs_declaration_number' => '10714040/140917/0090376',
                        'excise' => '20.00',
                        'supplier' => [
                            'name' => 'string',
                            'phone' => 'string',
                            'inn' => 'string'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @throws PaymentProviderException
     */
    private function paymentObject()
    {
        $request = $this->request();

        try {
            $notification = ($request['event'] === NotificationEventType::PAYMENT_SUCCESS)
                ? new NotificationSucceeded($request)
                : new NotificationWaitingForCapture($request);

        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();

            throw new PaymentProviderException($e->getMessage());
        }

        return $notification->getObject();
    }

    private function idempotenceKey(): string
    {
        return uniqid('', true);
    }

}
