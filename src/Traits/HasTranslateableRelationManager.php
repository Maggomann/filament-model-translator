<?php

namespace Maggomann\FilamentModelTranslator\Traits;

use Illuminate\Support\Str;
use Maggomann\FilamentModelTranslator\Contracts\Translateable;

trait HasTranslateableRelationManager
{
    use HasTranslateable;

    public static function modelToTranslate(): string
    {
        return (string) Str::of(static::getRelationshipName())
            ->kebab()
            ->replace('-', ' ')
            ->singular();
    }

    public static function interfaceIsNotPresent(): bool
    {
        return once(function () {
            return ! new static() instanceof Translateable;
        });
    }
}
