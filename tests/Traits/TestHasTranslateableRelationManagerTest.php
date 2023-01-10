<?php

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Maggomann\FilamentModelTranslator\Tests\Classes\TestHasTranslateableRelationManager;

it('returns the right model to translate string', function ($languageKey, $translation) {
    app()->singleton('translator', fn () => new Translator(new ArrayLoader(), $languageKey));
    app()->setLocale($languageKey);

    $this->assertSame($translation, TestHasTranslateableRelationManager::modelToTranslate());
})->with([
    ['de', 'testing model'],
    ['en', 'testing model'],
]);
