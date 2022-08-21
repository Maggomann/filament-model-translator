<?php

namespace Maggomann\FilamentModelTranslator;

use Maggomann\FilamentModelTranslator\Commands\FilamentModelTranslatorCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentModelTranslatorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-model-translator')
            ->hasConfigFile()
            ->hasCommand(FilamentModelTranslatorCommand::class);
    }
}
