<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Data;

use Assurdeal\LaravelOrias\Enums\RegistrationCategory;
use Illuminate\Support\Carbon;
use stdClass;

class Registration
{
    /**
     * Create a new instance of the DTO.
     */
    public function __construct(
        public string $categoryName,
        public ?string $status = null,
        public ?Carbon $registrationDate = null,
        public ?Carbon $deletionDate = null,
    ) {
    }

    /**
     * Determine if the registration matches the given category.
     */
    public function categoryMatches(RegistrationCategory $category): bool
    {
        return $this->categoryName === $category->value;
    }

    /**
     * Determine if the registration has valid date.
     */
    public function registrationDateIsValid(): bool
    {
        if (! $this->registrationDate) {
            return false;
        }

        if (! $this->deletionDate) {
            return now()->greaterThanOrEqualTo($this->registrationDate);
        }

        return now()->between($this->registrationDate, $this->deletionDate);
    }

    /**
     * Create a new instance of the DTO from the response.
     */
    public static function fromResponse(stdClass $response): Registration
    {
        return new static(
            categoryName: $response->categoryName,
            status: $response->status ?? null,
            registrationDate: isset($response->registrationDate) ? Carbon::parse($response->registrationDate) : null,
            deletionDate: isset($response->deletionDate) ? Carbon::parse($response->deletionDate) : null,
        );
    }
}
