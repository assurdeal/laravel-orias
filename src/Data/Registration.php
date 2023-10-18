<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Data;

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
