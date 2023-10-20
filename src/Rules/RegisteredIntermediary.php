<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Rules;

use Assurdeal\LaravelOrias\Data\Intermediary;
use Assurdeal\LaravelOrias\Enums\RegistrationCategory;
use Assurdeal\LaravelOrias\Requests\ShowBrokerRequest;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RegisteredIntermediary implements ValidationRule
{
    /**
     * ORIAS code length.
     */
    const REGISTRATION_NUMBER_LENGTH = 8;

    /**
     * Any of the categories of registrations that
     * are valid for the current request.
     *
     * @var array<RegistrationCategory>|null
     */
    protected ?array $anyValidRegistrations = null;

    /**
     * The categories of registrations that
     * are valid for the current request.
     *
     * @var array<RegistrationCategory>|null
     */
    protected ?array $allValidRegistrations = null;

    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) !== self::REGISTRATION_NUMBER_LENGTH) {
            $fail('The :attribute is not of a valid length.');

            return;
        }

        $response = ShowBrokerRequest::make($value)->send();

        if ($response->failed()) {
            $fail('The :attribute is not a registered intermediary.');

            return;
        }

        /** @var Intermediary $intermediary */
        $intermediary = $response->dto();

        if (! $intermediary->foundInRegistry) {
            $fail('The :attribute was not found in the registry of intermediaries.');

            return;
        }

        if ($this->anyValidRegistrations) {
            $valid = collect($this->anyValidRegistrations)
                ->filter(fn (RegistrationCategory $category) => $intermediary->isRegisteredAs($category))
                ->isNotEmpty();

            if (! $valid) {
                $fail('The :attribute is not registered for any of the valid categories.');

                return;
            }
        }

        if ($this->allValidRegistrations) {
            $valid = collect($this->allValidRegistrations)
                ->filter(fn (RegistrationCategory $category) => $intermediary->isRegisteredAs($category))
                ->count() === count($this->allValidRegistrations);

            if (! $valid) {
                $fail('The :attribute is not registered for all of the valid categories.');
            }
        }
    }

    /**
     * Set the categories of registrations that are valid for the current request.
     */
    public function withAnyOfCategories(RegistrationCategory ...$categories): self
    {
        $this->anyValidRegistrations = $categories;

        return $this;
    }

    /**
     * Set the categories of registrations that are valid for the current request.
     */
    public function withAllOfCategories(RegistrationCategory ...$categories): self
    {
        $this->allValidRegistrations = $categories;

        return $this;
    }
}
