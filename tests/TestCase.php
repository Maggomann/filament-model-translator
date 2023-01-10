<?php

namespace Maggomann\FilamentModelTranslator\Tests;

use Filament\FilamentServiceProvider;
use Livewire\LivewireServiceProvider;
use Maggomann\FilamentModelTranslator\FilamentModelTranslatorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            FilamentServiceProvider::class,
            FilamentModelTranslatorServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }
}
