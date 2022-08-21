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

    public static function transModelKey(): string
    {
        return once(function () {
            $model = new static();

            if ($model instanceof Resource) {
                $model = $model->getModel();
            }

            return Str::of(class_basename($model))->snake()->lower()->toString();
        });
    }

    public static function transAttribute(string $attribute): ?string
    {
        return trans(static::transPackageKey().'filament-model.attributes.'.static::transModelKey().'.'.$attribute);
    }

    public static function transModel(int $number = 1): ?string
    {
        return ($transValue = trans_choice(static::transPackageKey().'filament-model.models.'.static::transModelKey(), $number)) !== 'model.models.'.static::transModelKey()
            ? $transValue
            : null;
    }

    public static function transNavigationGroup(): ?string
    {
        return trans(static::transPackageKey().'filament-model.navigation_group.'.static::transModelKey().'.name');
    }

    protected static function transPackageKey(): string
    {
        return (new static())->transPackageKey() ?? '';
    }

    public static function getModelLabel(): string
    {
        if (static::noInterfaceIsPresent()) {
            return parent::getModelLabel();
        }

        return static::transModel(number: 1);
    }

    protected static function getNavigationGroup(): ?string
    {
        if (static::noInterfaceIsPresent()) {
            return parent::getNavigationGroup();
        }

        return static::transNavigationGroup();
    }

    public static function getPluralModelLabel(): string
    {
        if (static::noInterfaceIsPresent()) {
            return parent::getPluralModelLabel();
        }

        return static::transModel(number: 2);
    }
}
