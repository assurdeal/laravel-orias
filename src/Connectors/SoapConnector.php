<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Connectors;

use Assurdeal\LaravelOrias\Requests\SoapRequest;
use RicorocksDigitalAgency\Soap\Facades\Soap;
use RicorocksDigitalAgency\Soap\Request\Request as BaseSoapRequest;
use Assurdeal\LaravelOrias\Responses\SoapResponse;

class SoapConnector implements Connector
{
    /**
     * Create new instance of the connector.
     */
    public function __construct(
        protected string $wsdl,
        protected string $key,
        protected array $options = []
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function send(SoapRequest $request): SoapResponse
    {
        return SoapResponse::make(
            $this->soap()
                ->call(
                    $request->method(),
                    array_merge(['user' => $this->key], $request->parameters())
                ),
            $request
        );
    }

    /**
     * Construct a new SOAP request.
     */
    protected function soap(): BaseSoapRequest
    {
        return Soap::to($this->wsdl)
            ->withOptions($this->options);
    }
}
