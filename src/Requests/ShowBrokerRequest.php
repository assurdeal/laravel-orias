<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Requests;

use Assurdeal\LaravelOrias\Concerns\Makeable;
use Assurdeal\LaravelOrias\Concerns\SendableSoapRequest;
use Assurdeal\LaravelOrias\Data\Intermediary;
use RicorocksDigitalAgency\Soap\Response\Response;

class ShowBrokerRequest implements SoapRequest
{
    use Makeable, SendableSoapRequest;

    /**
     * Create a new instance of the request.
     */
    public function __construct(
        protected string $orias
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function method(): string
    {
        return 'intermediarySearch';
    }

    /**
     * {@inheritdoc}
     */
    public function parameters(): array
    {
        return [
            'intermediaries' => [
                [
                    'registrationNumber' => $this->orias,
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function createDtoFromResponse(Response $response): Intermediary
    {
        return Intermediary::fromResponse($response);
    }
}
