<?php

namespace Maggomann\FilamentModelTranslator\Traits;

use Filament\Resources\Resource;
use Illuminate\Support\Str;

trait HasTranslateableModels
{
    protected static ?string $translateableKeyAttribute = null;

    protected static ?string $translateableKeyName = null;

    protected static ?string $translateableKeyNavigationGroupe = null;

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

    protected static function transModelKey(): string
    {
        $model = new static();

        if ($model instanceof Resource) {
            $model = $model->getModel();
        }

        return Str::of(class_basename($model))->snake()->lower()->toString();
    }

    protected static function transPackageKey(): string
    {
        // TODO; interface
        // automatically generate package names
        $model = new static();

        return $model->transPackageKey() ?? '';
    }

    public static function getModelLabel(): string
    {
        return static::transModel(number: 1) ?? static::$modelLabel ?? static::getLabel() ?? get_model_label(static::getModel());
    }

    protected static function getNavigationGroup(): ?string
    {
        return static::transNavigationGroup() ?? static::transModel(number: 1) ?? static::$navigationGroup ?? null;
    }

    public static function getPluralModelLabel(): string
    {
        return static::transModel(number: 2) ?? static::getModelLabel() ?? '';
    }
}
