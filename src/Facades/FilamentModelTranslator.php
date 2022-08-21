<?php

namespace Maggomann\FilamentModelTranslator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Maggomann\FilamentModelTranslator\FilamentModelTranslator
 */
class FilamentModelTranslator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-model-translator';
    }
}
