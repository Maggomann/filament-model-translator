<?php

namespace Maggomann\FilamentModelTranslator\Contracts;

interface TranslateableResources
{
    public static function getModelLabel(): string;

    public static function getPluralModelLabel(): string;

    public static function translationKeyOfTheModel(string $modelName): string;

    public static function translateablePackageKey(): ?string;

    public static function keyIsNotTranslated(string $translationKey, string $translation): bool;

    public static function noInterfaceIsPresent(): bool;
}
