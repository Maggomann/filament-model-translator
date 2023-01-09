<?php

namespace Maggomann\FilamentModelTranslator\Tests;

use Maggomann\FilamentModelTranslator\FilamentModelTranslatorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            FilamentModelTranslatorServiceProvider::class,
        ];
    }
}
