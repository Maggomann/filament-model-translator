<?php

namespace Maggomann\FilamentModelTranslator\Tests\Classes;

use Filament\Resources\RelationManagers\RelationManager;
use Maggomann\FilamentModelTranslator\Contracts\Translateable;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableRelationManager;

class TestHasTranslateableRelationManager extends RelationManager implements Translateable
{
    use HasTranslateableRelationManager;

    protected static ?string $translateablePackageKey = '';

    protected static string $relationship = 'TestingModel';
}
