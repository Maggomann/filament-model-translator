<?php

namespace Maggomann\FilamentModelTranslator\Traits;

use Illuminate\Support\Str;

trait HasTranslateableModel
{
    public static function translationKeyOfTheModel(string $modelClass): string
    {
        return once(function () use ($modelClass) {
            return Str::of(class_basename($modelClass))->snake()->lower()->toString();
        });
    }

    public static function translateablePackageKey(): string
    {
        return static::$translateablePackageKey;
    }

    public static function transAttribute(string $attribute): ?string
    {
        $keyToBeTranslated = 'filament-model.attributes.'.static::translationKeyOfTheModel(static::class).".{$attribute}";

        return static::transParameter(
            keyToBeTranslated: $keyToBeTranslated,
        );
    }

    private static function transParameter(string $keyToBeTranslated): ?string
    {
        return once(function () use ($keyToBeTranslated) {
            $translationKey = static::translateablePackageKey().$keyToBeTranslated;

            return trans($translationKey);
        });
    }
}
