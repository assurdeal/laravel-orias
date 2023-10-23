# Laravel ORIAS webservice integration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/assurdeal/laravel-orias.svg?style=flat-square)](https://packagist.org/packages/assurdeal/laravel-orias)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/assurdeal/laravel-orias/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/assurdeal/laravel-orias/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/assurdeal/laravel-orias/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/assurdeal/laravel-orias/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/assurdeal/laravel-orias.svg?style=flat-square)](https://packagist.org/packages/assurdeal/laravel-orias)

This package allows you to integrate the ORIAS webservice into your Laravel application. 
You can use it to validate an ORIAS number, or to retrieve information about a Broker.

## Installation

You can install the package via composer:

```bash
composer require assurdeal/laravel-orias
```

Add your ORIAS webservice API key to your `.env` file

```bash
ORIAS_KEY=your-api-key
```

## Usage

```php
use Assurdeal\LaravelOrias\Requests\ShowBrokerRequest;

$response = ShowBrokerRequest::make('123456789')->send();

/** @var \Assurdeal\LaravelOrias\Data\Intermediary $dto */
$dto = $response->dto();
```

## Usage as validator

```php
use Assurdeal\LaravelOrias\Rules\RegisteredIntermediary;
use Assurdeal\LaravelOrias\Enums\RegistrationCategory;

Validator::make($data, [
    'orias' => ['required', new RegisteredIntermediary()],
]);

Validator::make($data, [
    'orias' => [
        'required', 
        (new RegisteredIntermediary())->withAllOfCategories(
            RegistrationCategory::COA,
            RegistrationCategory::AGA
        )
    ],
]);

Validator::make($data, [
    'orias' => [
        'required', 
        (new RegisteredIntermediary())->withAnyOfCategories(
            RegistrationCategory::COA,
            RegistrationCategory::AGA
        )
    ],
]);
```

## Testing

```bash
composer test
```

## Credits

- [Percy Mamedy](https://github.com/percymamedy)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
