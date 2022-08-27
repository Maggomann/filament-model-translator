<?php

namespace Maggomann\FilamentModelTranslator\Traits;

use Illuminate\Support\Str;

trait HasTranslateableModel
{
    public static function translationKeyOfTheModel(): string
    {
        return once(function () {
            return Str::of(class_basename(new static()))->snake()->lower()->toString();
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
            parameter: $attribute,
        );
    }

    private static function transParameter(string $keyToBeTranslated, string $parameter): ?string
    {
        return once(function () use ($keyToBeTranslated, $parameter) {
            $equalTranslationKey = $keyToBeTranslated.static::translationKeyOfTheModel().".{$parameter}";
            $translationKey = static::translateablePackageKey().$equalTranslationKey;

            return trans($translationKey);
        });
    }
}
