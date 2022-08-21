<?php

namespace Maggomann\FilamentModelTranslator\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Maggomann\FilamentModelTranslator\FilamentModelTranslatorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Maggomann\\FilamentModelTranslator\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentModelTranslatorServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-model-translator_table.php.stub';
        $migration->up();
        */
    }
}
