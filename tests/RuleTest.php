<?php

declare(strict_types=1);

use Assurdeal\LaravelOrias\Enums\RegistrationCategory;
use Assurdeal\LaravelOrias\Rules\RegisteredIntermediary;
use Illuminate\Support\Carbon;
use RicorocksDigitalAgency\Soap\Facades\Soap;
use RicorocksDigitalAgency\Soap\Response\Response;

it('passes validation when correct orias number is provided', function () {
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

    $validator = validator(
        data: ['orias' => '12345678'],
        rules: [
            'orias' => [
                'required',
                new RegisteredIntermediary(),
            ],
        ]
    );

    expect($validator->passes())
        ->toBeTrue();
});

it('passes validation when correct orias number is provided and has registered category', function () {
    Carbon::setTestNow('2022-01-01');

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

    $validator = validator(
        data: ['orias' => '12345678'],
        rules: [
            'orias' => [
                'required',
                (new RegisteredIntermediary())
                    ->withAnyOfCategories(
                        RegistrationCategory::AGA,
                        RegistrationCategory::COA,
                    ),
            ],
        ]
    );

    expect($validator->passes())
        ->toBeTrue();
});

it('fails validation when correct orias number is provided but not registered to all categories', function () {
    Carbon::setTestNow('2022-01-01');

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

    $validator = validator(
        data: ['orias' => '12345678'],
        rules: [
            'orias' => [
                'required',
                (new RegisteredIntermediary())
                    ->withAllOfCategories(
                        RegistrationCategory::AGA,
                        RegistrationCategory::COA,
                    ),
            ],
        ]
    );

    expect($validator->passes())
        ->toBeFalse();
});
