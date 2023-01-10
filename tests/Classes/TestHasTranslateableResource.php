<?php

namespace Maggomann\FilamentModelTranslator\Tests\Classes;

use Filament\Resources\Resource;
use Maggomann\FilamentModelTranslator\Contracts\Translateable;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableResources;

class TestHasTranslateableResource extends Resource implements Translateable
{
    use HasTranslateableResources;

    protected static ?string $translateablePackageKey = '';

    protected static ?string $model = TestModelTranslateableModel::class;

    public static function getNavigationGroupForTest(): ?string
    {
        return static::getNavigationGroup();
    }
}
