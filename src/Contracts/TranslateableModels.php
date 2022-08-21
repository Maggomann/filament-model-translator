<?php

namespace Maggomann\FilamentModelTranslator\Contracts;

interface TranslateableModels
{
    public static function transAttribute(string $attribute): ?string;

    public static function transModel(int $number = 1): ?string;

    public static function transNavigationGroup(): ?string;

    public static function transModelKey(): string;

    public function transPackageKey(): ?string;

    public static function getModelLabel(): string;
}
