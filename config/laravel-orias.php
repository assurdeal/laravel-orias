<?php

declare(strict_types=1);

return [
    'orias' => [
        'key' => env('ORIAS_KEY'),
        'wsdl' => env('ORIAS_WSDL', 'https://ws.orias.fr/service?wsdl'),
        'options' => [
            'uri' => 'http://schemas.xmlsoap.org/soap/envelope/',
            'style' => SOAP_RPC,
            'use' => SOAP_ENCODED,
            'soap_version' => SOAP_1_1,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'connection_timeout' => 30,
            'trace' => true,
            'encoding' => 'UTF-8',
            'exceptions' => true,
        ],
    ],
];
