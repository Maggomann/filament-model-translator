<?php

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Maggomann\FilamentModelTranslator\Tests\Classes\TestHasTranslateableRelationManager;
use Maggomann\FilamentModelTranslator\Tests\Classes\TestHasTranslateableResource;
use Maggomann\FilamentModelTranslator\Tests\Classes\TestModelTranslateableModel;

beforeEach(function () {
    $this->loader = new ArrayLoader();
    $this->loader->addMessages(
        'de',
        'filament-model',
        [
            'models' => [
                'test_model_translateable_model' => 'Einzahl|Mehrzahl',
            ],
            'navigation_group' => [
                'test_model_translateable_model' => [
                    'name' => 'Beispiel Navigationsname',
                ],
            ],
        ],
    );

    $this->loader->addMessages(
        'en',
        'filament-model',
        [
            'models' => [
                'test_model_translateable_model' => 'Single number|Multiple number',
            ],
            'navigation_group' => [
                'test_model_translateable_model' => [
                    'name' => 'Example navigation name',
                ],
            ],
        ],
    );
});

it('returns the correct model class name', function () {
    $this->assertSame(TestModelTranslateableModel::class, TestHasTranslateableResource::modelToTranslate());
});

it('returns the right model label', function ($languageKey, $translation) {
    app()->singleton('translator', fn () => new Translator($this->loader, $languageKey));
    app()->setLocale($languageKey);

    $this->assertSame($translation, TestHasTranslateableResource::getModelLabel());
})->with([
    ['de', 'Einzahl'],
    ['en', 'Single number'],
]);

it('returns the right plural model label', function ($languageKey, $translation) {
    app()->singleton('translator', fn () => new Translator($this->loader, $languageKey));
    app()->setLocale($languageKey);

    $this->assertSame($translation, TestHasTranslateableResource::getPluralModelLabel());
})->with([
    ['de', 'Mehrzahl'],
    ['en', 'Multiple number'],
]);

it('returns the right navigation label', function ($languageKey, $translation) {
    app()->singleton('translator', fn () => new Translator($this->loader, $languageKey));
    app()->setLocale($languageKey);

    $this->assertFalse(TestHasTranslateableResource::interfaceIsNotPresent());
    $this->assertSame($translation, TestHasTranslateableResource::getNavigationGroupForTest());
})->with([
    ['de', 'Beispiel Navigationsname'],
    ['en', 'Example navigation name'],
]);

it('returns the right model to translate string', function ($languageKey, $translation) {
    app()->singleton('translator', fn () => new Translator($this->loader, $languageKey));
    app()->setLocale($languageKey);

    $this->assertSame($translation, TestHasTranslateableRelationManager::modelToTranslate());
})->with([
    ['de', 'testing model'],
    ['en', 'testing model'],
]);
