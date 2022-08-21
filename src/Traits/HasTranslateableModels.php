<?php

namespace Maggomann\FilamentModelTranslator\Traits;

use Filament\Resources\Resource;
use Illuminate\Support\Str;
use Maggomann\FilamentModelTranslator\Contracts\TranslateableModels;

trait HasTranslateableModels
{
    protected static ?string $translateableKeyAttribute = null;

    protected static ?string $translateableKeyName = null;

    protected static ?string $translateableKeyNavigationGroupe = null;

    public static function noInterfaceIsPresent(): bool
    {
        return once(function () {
            return ! new static() instanceof TranslateableModels;
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

    public static function transModelKey(): string
    {
        $model = new static();

        if ($model instanceof Resource) {
            $model = $model->getModel();
        }

        return Str::of(class_basename($model))->snake()->lower()->toString();
    }

    public static function transPackageKey(): string
    {
        return static::$translateableKey;
    }

    public static function getModelLabel(): string
    {
        if (static::noInterfaceIsPresent()) {
            return parent::getModelLabel();
        }

        $equalTranslationKey = 'filament-model.models.'.static::transModelKey();
        $translationKey = static::transPackageKey().$equalTranslationKey;

        $translation = trans_choice($translationKey, number: 1);

        if (static::keyIsNotTranslated($translationKey, $translation)) {
            return parent::getModelLabel();
        }

        return $translation;
    }

    public static function getPluralModelLabel(): string
    {
        if (static::noInterfaceIsPresent()) {
            return parent::getPluralModelLabel();
        }

        $equalTranslationKey = 'filament-model.models.'.static::transModelKey();
        $translationKey = static::transPackageKey().$equalTranslationKey;

        $translation = trans_choice($translationKey, number: 2);

        if (static::keyIsNotTranslated($translationKey, $translation)) {
            return parent::getPluralModelLabel();
        }

        return $translation;
    }

    protected static function getNavigationGroup(): ?string
    {
        if (static::noInterfaceIsPresent()) {
            return parent::getNavigationGroup();
        }

        $equalTranslationKey = 'filament-model.navigation_group.'.static::transModelKey().'.name';
        $translationKey = ''.static::transPackageKey().$equalTranslationKey;

        $translation = trans($translationKey);

        if (static::keyIsNotTranslated($translationKey, $translation)) {
            return parent::getPluralModelLabel();
        }

        return $translation;
    }
}
