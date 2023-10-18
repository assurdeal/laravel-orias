<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias;

use Assurdeal\LaravelOrias\Connectors\Connector;
use Assurdeal\LaravelOrias\Connectors\SoapConnector;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class LaravelOriasServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-orias.php',
            'services'
        );

        $this->app->bind(Connector::class, function () {
            $config = config('services.orias');

            return new SoapConnector(
                wsdl: $config['wsdl'],
                key: $config['key'],
                options: $config['options']
            );
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            Connector::class,
        ];
    }
}
