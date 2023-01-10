<?php

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Maggomann\FilamentModelTranslator\Tests\Classes\TestModelTranslateableModel;

beforeEach(function () {
    $loader = new ArrayLoader();
    $loader->addMessages(
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
    $loader->addMessages(
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
    app()->singleton('translator', fn () => new Translator($loader, 'de'));
});

it('returns the right translation key of the model', function () {
    $testModel = new TestModelTranslateableModel();

    $this->assertSame('test_model_translateable_model', $testModel::translationKeyOfTheModel($testModel::class));
});

it('returns the right translation attribute', function ($languageKey, $translation) {
    app()->setLocale($languageKey);

    $testModel = new TestModelTranslateableModel();

    $this->assertSame($translation, $testModel::transAttribute('example'));
})->with([
    ['de', 'Beispiel'],
    ['en', 'Example'],
]);

it(
    'returns the correct translation attribute when we switch to another language',
    function (
        $localKey,
        $switchLocale,
        $translation
    ) {
        app()->setLocale($localKey);

        $testModel = new TestModelTranslateableModel();

        $this->assertSame($translation, $testModel::transAttribute('example', [], $switchLocale));
    })->with([
        ['de', 'en', 'Example'],
        ['en', 'de', 'Beispiel'],
    ]);
