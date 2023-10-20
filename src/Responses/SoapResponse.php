<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Responses;

use Assurdeal\LaravelOrias\Concerns\Makeable;
use Assurdeal\LaravelOrias\Data\Data;
use Assurdeal\LaravelOrias\Requests\SoapRequest;
use RicorocksDigitalAgency\Soap\Response\Response;
use SoapFault;

class SoapResponse
{
    use Makeable;

    /**
     * Create a new instance of the response.
     */
    public function __construct(
        protected SoapRequest $request,
        protected ?Response $response = null,
        protected ?SoapFault $exception = null
    ) {
    }

    /**
     * Get DTO from the response.
     */
    public function dto(): ?Data
    {
        if ($this->exception || ! $this->response) {
            return null;
        }

        return $this->request->createDtoFromResponse($this->response);
    }

    /**
     * Determine if the request failed.
     */
    public function failed(): bool
    {
        return ! is_null($this->exception);
    }

    /**
     * Determine if the request succeeded.
     */
    public function success(): bool
    {
        return is_null($this->exception) && ! is_null($this->response);
    }
}
