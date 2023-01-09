<?php

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Maggomann\FilamentModelTranslator\Tests\Model\TestModelTranslateableModel;

beforeEach(function () {
    $this->loader = new ArrayLoader();
    $this->loader->addMessages(
        'de',
        'filament-model',
        [
            'attributes' => [
                'test_model_translateable_model' => [
                    'example' => 'Beispiel',
                ],
            ],
        ]
    );
    $this->loader->addMessages(
        'en',
        'filament-model',
        [
            'attributes' => [
                'test_model_translateable_model' => [
                    'example' => 'Example',
                ],
            ],
        ]
    );
});

it('returns the right translation key of the model', function () {
    $testModel = new TestModelTranslateableModel();

    $this->assertSame('test_model_translateable_model', $testModel::translationKeyOfTheModel($testModel::class));
});

it('returns the right trans attribute', function ($languageKey, $translation) {
    app()->singleton('translator', fn () => new Translator($this->loader, $languageKey));
    app()->setLocale($languageKey);

    $testModel = new TestModelTranslateableModel();

    $this->assertSame($translation, $testModel::transAttribute('example'));
})->with([
    ['de', 'Beispiel'],
    ['en', 'Example'],
]);
