<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Tests;

use Assurdeal\LaravelOrias\LaravelOriasServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RicorocksDigitalAgency\Soap\Providers\SoapServiceProvider;

class TestCase extends Orchestra
{
    /**
     * Get package providers.
     */
    protected function getPackageProviders($app): array
    {
        return [
            SoapServiceProvider::class,
            LaravelOriasServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     */
    public function getEnvironmentSetUp($app): void
    {
        config()->set('services.orias.key', 'testing');
        config()->set('services.orias.wsdl', 'https://ws.orias.fr/service?wsdl');
        config()->set('services.orias.options', [
            'uri' => 'http://schemas.xmlsoap.org/soap/envelope/',
            'style' => SOAP_RPC,
            'use' => SOAP_ENCODED,
            'soap_version' => SOAP_1_1,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'connection_timeout' => 30,
            'trace' => true,
            'encoding' => 'UTF-8',
            'exceptions' => true,
        ]);
    }
}
