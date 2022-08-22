<?php

namespace Maggomann\FilamentModelTranslator\Traits;

use Closure;
use Illuminate\Support\Str;
use Maggomann\FilamentModelTranslator\Contracts\TranslateableResources;

trait HasTranslateableResources
{
    protected static ?string $translateableKeyAttribute = null;

    protected static ?string $translateableKeyName = null;

    protected static ?string $translateableKeyNavigationGroupe = null;

    public static function noInterfaceIsPresent(): bool
    {
        return once(function () {
            return ! new static() instanceof TranslateableResources;
        });
    }

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

    public static function transResourceKey(): string
    {
        $model = (new static())->getModel();

        return Str::of(class_basename($model))->snake()->lower()->toString();
    }

    public static function translateablePackageKey(): string
    {
        return static::$translateablePackageKey;
    }

    public static function getModelLabel(): string
    {
        if (static::noInterfaceIsPresent()) {
            return parent::getModelLabel();
        }

        return static::transChoice(
            keyToBeTranslated: 'filament-model.models.',
            number: 1,
            defaultCallback: fn () => parent::getModelLabel()
        );
    }

    public static function getPluralModelLabel(): string
    {
        if (static::noInterfaceIsPresent()) {
            return parent::getPluralModelLabel();
        }

        return static::transChoice(
            keyToBeTranslated: 'filament-model.models.',
            number: 1,
            defaultCallback: fn () => parent::getPluralModelLabel()
        );
    }

    protected static function getNavigationGroup(): ?string
    {
        if (static::noInterfaceIsPresent()) {
            return parent::getNavigationGroup();
        }

        return static::trans(
            keyToBeTranslated: 'filament-model.navigation_group.',
            defaultCallback: fn () => parent::getNavigationGroup()
        );
    }

    private static function trans($keyToBeTranslated, Closure $defaultCallback): ?string
    {
        $equalTranslationKey = $keyToBeTranslated.static::transResourceKey().'.name';
        $translationKey = ''.static::translateablePackageKey().$equalTranslationKey;

        $translation = trans($translationKey);

        if (static::keyIsNotTranslated($translationKey, $translation)) {
            return $defaultCallback();
        }

        return $translation;
    }

    private static function transChoice(string $keyToBeTranslated, int $number, Closure $defaultCallback): ?string
    {
        $equalTranslationKey = $keyToBeTranslated.static::transResourceKey();
        $translationKey = ''.static::translateablePackageKey().$equalTranslationKey;

        $translation = trans_choice($translationKey, $number);

        if (static::keyIsNotTranslated($translationKey, $translation)) {
            return $defaultCallback();
        }

        return $translation;
    }
}
