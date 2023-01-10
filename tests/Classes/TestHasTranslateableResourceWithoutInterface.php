<?php

namespace Maggomann\FilamentModelTranslator\Tests\Classes;

use Filament\Resources\Resource;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableResources;

class TestHasTranslateableResourceWithoutInterface extends Resource
{
    use HasTranslateableResources;

    protected static ?string $translateablePackageKey = '';

    protected static ?string $model = TestModelTranslateableModel::class;

    public static function getNavigationGroupForTest(): ?string
    {
        return static::getNavigationGroup();
    }
}
