<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Data;

use Assurdeal\LaravelOrias\Enums\RegistrationCategory;
use RicorocksDigitalAgency\Soap\Response\Response;

class Intermediary implements Data
{
    /**
     * Create a new instance of the DTO.
     *
     * @param  array<Registration>  $registrations
     */
    public function __construct(
        public string $registrationNumber,
        public bool $foundInRegistry = false,
        public ?string $siren = null,
        public ?string $denomination = null,
        public array $registrations = [],
    ) {}

    /**
     * Determine if the intermediary is registered for a given category.
     */
    public function isRegisteredAs(RegistrationCategory $category): bool
    {
        foreach ($this->registrations as $registration) {
            if ($registration->categoryMatches($category) && $registration->registrationDateIsValid()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponse(Response $response): Intermediary
    {
        $intermediary = $response->response?->intermediaries?->intermediary;

        $baseInformation = $intermediary?->informationBase;
        $registrations = $intermediary?->registrations?->registration ?? [];

        // When we have only one results the Web service will return an
        // object instead, so we put it as the first item in an
        // array, so we can keep a similar logic for both
        // situations.
        if (! is_array($registrations)) {
            $registrations = [$registrations];
        }

        return new static(
            registrationNumber: $baseInformation?->registrationNumber ?? '',
            foundInRegistry: $baseInformation?->foundInRegistry ?? false,
            siren: $baseInformation?->siren ?? null,
            denomination: $baseInformation?->denomination ?? null,
            registrations: collect($registrations)->map(fn ($registration) => Registration::fromResponse($registration))->all()
        );
    }
}
