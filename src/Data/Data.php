<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Data;

use RicorocksDigitalAgency\Soap\Response\Response;

interface Data
{
    /**
     * Build the DTO from the SOAP response.
     */
    public static function fromResponse(Response $response): self;
}
