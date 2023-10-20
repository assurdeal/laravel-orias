<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Connectors;

use Assurdeal\LaravelOrias\Requests\SoapRequest;
use Assurdeal\LaravelOrias\Responses\SoapResponse;
use RicorocksDigitalAgency\Soap\Facades\Soap;
use RicorocksDigitalAgency\Soap\Request\Request as BaseSoapRequest;
use SoapFault;

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
        try {
            $method = $request->method();
            $parameters = array_merge(['user' => $this->key], $request->parameters());

            return SoapResponse::make(
                response: $this->soap()->call($method, $parameters),
                request: $request
            );
        } catch (SoapFault $exception) {
            return SoapResponse::make(
                request: $request,
                exception: $exception
            );
        }
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
