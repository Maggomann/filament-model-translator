<?php

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Maggomann\FilamentModelTranslator\Tests\Classes\TestHasTranslateableResourceWithoutInterface;

beforeEach(function () {
    $loader = new ArrayLoader();
    app()->singleton('translator', fn () => new Translator($loader, 'de'));
});

it('returns the default model label', function ($languageKey, $translation) {
    app()->setLocale($languageKey);

    $this->assertSame($translation, TestHasTranslateableResourceWithoutInterface::getModelLabel());
})->with([
    ['de', 'test model translateable model'],
    ['en', 'test model translateable model'],
]);

it('returns the default as plural model label', function ($languageKey, $translation) {
    app()->setLocale($languageKey);

    $this->assertSame($translation, TestHasTranslateableResourceWithoutInterface::getPluralModelLabel());
})->with([
    ['de', 'test model translateable models'],
    ['en', 'test model translateable models'],
]);

it('returns null as navigation label', function ($languageKey, $translation) {
    app()->setLocale($languageKey);

    $this->assertTrue(TestHasTranslateableResourceWithoutInterface::interfaceIsNotPresent());
    $this->assertSame($translation, TestHasTranslateableResourceWithoutInterface::getNavigationGroupForTest());
})->with([
    ['de', null],
    ['en', null],
]);
