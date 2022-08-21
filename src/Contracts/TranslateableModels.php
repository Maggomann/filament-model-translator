<?php

namespace Maggomann\FilamentModelTranslator\Contracts;

interface TranslateableModels
{
    public static function getModelLabel(): string;

    public static function getPluralModelLabel(): string;

    public static function transModelKey(): string;

    public static function transPackageKey(): ?string;

    public static function keyIsNotTranslated(): bool;

    public static function noInterfaceIsPresent(): bool;
}
