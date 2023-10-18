<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Concerns;

use Assurdeal\LaravelOrias\Connectors\Connector;
use Assurdeal\LaravelOrias\Responses\SoapResponse;

trait SendableSoapRequest
{
    /**
     * Send the request to the ORIAS API.
     */
    public function send(): SoapResponse
    {
        return resolve(Connector::class)->send($this);
    }
}
