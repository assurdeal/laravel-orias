<?php

declare(strict_types=1);

use Assurdeal\LaravelOrias\Data\Intermediary;
use Assurdeal\LaravelOrias\Data\Registration;
use Assurdeal\LaravelOrias\Requests\ShowBrokerRequest;
use RicorocksDigitalAgency\Soap\Facades\Soap;
use RicorocksDigitalAgency\Soap\Response\Response;

it('can return an instance of the Intermediary DTO from request', function () {
    $response = [
        'intermediaries' => (object) [
            'intermediary' => (object) [
                'informationBase' => (object) [
                    'siren' => '123456789',
                    'registrationNumber' => '12345678',
                    'denomination' => 'Foo Bar',
                    'foundInRegistry' => true,
                ],
                'registrations' => (object) [
                    'registration' => (object) [
                        'categoryName' => 'COA',
                        'status' => 'INSCRIT',
                        'registrationDate' => '2021-01-01',
                        'collectFunds' => false,
                        'bankActivities' => (object) [],
                    ],
                ],
            ],
        ],
    ];

    Soap::fake([
        'https://ws.orias.fr/service?wsdl' => Response::new((object) $response),
    ]);

    $dto = ShowBrokerRequest::make('123456789')
        ->send()
        ->dto();

    expect($dto)
        ->toBeInstanceOf(Intermediary::class)
        ->and($dto->registrationNumber)
        ->toBe('12345678')
        ->and($dto->siren)
        ->toBe('123456789')
        ->and($dto->denomination)
        ->toBe('Foo Bar')
        ->and($dto->foundInRegistry)
        ->toBeTrue()
        ->and($dto->registrations)
        ->toBeArray()
        ->and($dto->registrations[0])
        ->toBeInstanceOf(Registration::class)
        ->and($dto->registrations[0]->categoryName)
        ->toBe('COA')
        ->and($dto->registrations[0]->status)
        ->toBe('INSCRIT')
        ->and($dto->registrations[0]->registrationDate)
        ->toBeInstanceOf(Carbon\Carbon::class)
        ->and($dto->registrations[0]->registrationDate->toDateString())
        ->toBe('2021-01-01');
});
