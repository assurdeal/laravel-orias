<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Connectors;

use Assurdeal\LaravelOrias\Requests\SoapRequest;
use Assurdeal\LaravelOrias\Responses\SoapResponse;

interface Connector
{
    /**
     * Send a request to the ORIAS API.
     */
    public function send(SoapRequest $request): SoapResponse;
}
