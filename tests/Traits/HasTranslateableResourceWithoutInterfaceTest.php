<?php

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Maggomann\FilamentModelTranslator\Tests\Classes\TestHasTranslateableResourceWithoutInterface;

beforeEach(function () {
    $this->loader = new ArrayLoader();
});

it('returns the default model label', function ($languageKey, $translation) {
    app()->singleton('translator', fn () => new Translator($this->loader, $languageKey));
    app()->setLocale($languageKey);

    $this->assertSame($translation, TestHasTranslateableResourceWithoutInterface::getModelLabel());
})->with([
    ['de', 'test model translateable model'],
    ['en', 'test model translateable model'],
]);

it('returns the default as plural model label', function ($languageKey, $translation) {
    app()->singleton('translator', fn () => new Translator($this->loader, $languageKey));
    app()->setLocale($languageKey);

    $this->assertSame($translation, TestHasTranslateableResourceWithoutInterface::getPluralModelLabel());
})->with([
    ['de', 'test model translateable models'],
    ['en', 'test model translateable models'],
]);

it('returns null as navigation label', function ($languageKey, $translation) {
    app()->singleton('translator', fn () => new Translator($this->loader, $languageKey));
    app()->setLocale($languageKey);

    $this->assertTrue(TestHasTranslateableResourceWithoutInterface::interfaceIsNotPresent());
    $this->assertSame($translation, TestHasTranslateableResourceWithoutInterface::getNavigationGroupForTest());
})->with([
    ['de', null],
    ['en', null],
]);
