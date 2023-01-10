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

    public static function transAttribute(string $attribute, array $replace = [], ?string $locale = null): ?string
    {
        if (is_null($locale)) {
            $locale = app()->getLocale();
        }

        $keyToBeTranslated = 'filament-model.attributes.'.static::translationKeyOfTheModel(static::class).".{$attribute}";

        return static::transParameter(
            keyToBeTranslated: $keyToBeTranslated,
            replace: $replace,
            locale: $locale
        );
    }

    private static function transParameter(string $keyToBeTranslated, array $replace, string $locale): ?string
    {
        return once(function () use ($keyToBeTranslated, $replace, $locale) {
            $translationKey = static::translateablePackageKey().$keyToBeTranslated;

            return trans($translationKey, $replace, $locale);
        });
    }
}
