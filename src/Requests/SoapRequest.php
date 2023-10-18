<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Requests;

use Assurdeal\LaravelOrias\Data\Data;
use RicorocksDigitalAgency\Soap\Response\Response;

interface SoapRequest
{
    /**
     * Get the method name to call.
     */
    public function method(): string;

    /**
     * Get the parameters to send.
     */
    public function parameters(): array;

    /**
     * Build the DTO from the SOAP response.
     */
    public function createDtoFromResponse(Response $response): Data;
}
