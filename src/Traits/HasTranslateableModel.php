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

    protected static function transAttribute(string $attribute): ?string
    {
        return static::transParameter(
            keyToBeTranslated: 'filament-model.attributes.',
            modelClass: static::class,
            parameter: $attribute,
        );
    }

    private static function transParameter(string $keyToBeTranslated, string $modelClass, string $parameter): ?string
    {
        $equalTranslationKey = $keyToBeTranslated.static::translationKeyOfTheModel($modelClass).".{$parameter}";

        return once(function () use ($equalTranslationKey) {
            $translationKey = static::translateablePackageKey().$equalTranslationKey;

            return trans($translationKey);
        });
    }
}
