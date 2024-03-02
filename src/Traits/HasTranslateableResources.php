<?php

namespace Maggomann\FilamentModelTranslator\Traits;

use Maggomann\FilamentModelTranslator\Contracts\Translateable;

trait HasTranslateableResources
{
    use HasTranslateable;

    protected static ?string $translateableKeyAttribute = null;

    protected static ?string $translateableKeyName = null;

    protected static ?string $translateableKeyNavigationGroupe = null;

    public static function modelToTranslate(): string
    {
        return static::getModel();
    }

    public static function interfaceIsNotPresent(): bool
    {
        return once(function () {
            return ! new static() instanceof Translateable;
        });
    }

    public static function getNavigationGroup(): ?string
    {
        if (static::interfaceIsNotPresent()) {
            return parent::getNavigationGroup();
        }

        $keyToBeTranslated = 'filament-model.navigation_group.'.static::translationKeyOfTheModel(static::modelToTranslate()).'.name';

        return static::trans(
            keyToBeTranslated: $keyToBeTranslated,
            defaultCallback: fn () => parent::getNavigationGroup()
        );
    }
}
