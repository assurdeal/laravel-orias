<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Assurdeal\LaravelOrias\LaravelOriasServiceProvider;
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
            LaravelOriasServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     */
    public function getEnvironmentSetUp($app): void
    {
        config()->set('services.orias.key', 'testing');
        config()->set('services.orias.wsdl', 'https://ws.orias.fr/service?wsdl');
    }
}
