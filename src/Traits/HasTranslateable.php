<?php

namespace Maggomann\FilamentModelTranslator\Traits;

use Closure;
use Illuminate\Support\Str;

trait HasTranslateable
{
    public static function keyIsNotTranslated($translationKey, $translation): bool
    {
        if ($translation === null) {
            return true;
        }

        if ($translation === '') {
            return true;
        }

        return $translationKey === $translation;
    }

    public static function translationKeyOfTheModel(string $modelName): string
    {
        return once(function () use ($modelName) {
            return Str::of(class_basename($modelName))->snake()->lower()->toString();
        });
    }

    public static function translateablePackageKey(): string
    {
        return static::$translateablePackageKey;
    }

    public static function getModelLabel(): string
    {
        if (static::interfaceIsNotPresent()) {
            return parent::getModelLabel();
        }

        $keyToBeTranslated = 'filament-model.models.'.static::translationKeyOfTheModel(static::modelToTranslate());

        return static::transChoice(
            keyToBeTranslated: $keyToBeTranslated,
            number: 1,
            defaultCallback: fn () => parent::getModelLabel()
        );
    }

    public static function getPluralModelLabel(): string
    {
        if (static::interfaceIsNotPresent()) {
            return parent::getPluralModelLabel();
        }

        $keyToBeTranslated = 'filament-model.models.'.static::translationKeyOfTheModel(static::modelToTranslate());

        return static::transChoice(
            keyToBeTranslated: $keyToBeTranslated,
            number: 2,
            defaultCallback: fn () => parent::getPluralModelLabel()
        );
    }

    private static function trans($keyToBeTranslated, Closure $defaultCallback): ?string
    {
        return once(function () use ($keyToBeTranslated, $defaultCallback) {
            $translationKey = ''.static::translateablePackageKey().$keyToBeTranslated;

            $translation = trans($translationKey);

            if (static::keyIsNotTranslated($translationKey, $translation)) {
                return $defaultCallback();
            }

            return $translation;
        });
    }

    private static function transChoice(string $keyToBeTranslated, int $number, Closure $defaultCallback): ?string
    {
        return once(function () use ($keyToBeTranslated, $number, $defaultCallback) {
            $translationKey = ''.static::translateablePackageKey().$keyToBeTranslated;

            $translation = trans_choice($translationKey, $number);

            if (static::keyIsNotTranslated($translationKey, $translation)) {
                return $defaultCallback();
            }

            return $translation;
        });
    }
}
