<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Responses;

use Assurdeal\LaravelOrias\Concerns\Makeable;
use Assurdeal\LaravelOrias\Data\Data;
use Assurdeal\LaravelOrias\Requests\SoapRequest;
use RicorocksDigitalAgency\Soap\Response\Response;

class SoapResponse
{
    use Makeable;

    /**
     * Create a new instance of the response.
     */
    public function __construct(
        protected Response $response,
        protected SoapRequest $request
    ) {
    }

    /**
     * Get DTO from the response.
     */
    public function dto(): Data
    {
        return $this->request->createDtoFromResponse($this->response);
    }
}
