<?php

declare(strict_types=1);

namespace Assurdeal\LaravelOrias\Concerns;

trait Makeable
{
    /**
     * Create a new instance of the class.
     */
    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }
}
