# This is my package filament-model-translator

## Work in progress (wip)
This package is still under development. Use at your own risk.

## Installation

Install package via composer.json file:
```json
    "require-dev": {
        "maggomann/filament-model-translator": "dev-beta",
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:Maggomann/filament-model-translator.git"
        }
    ]
```

## How is it used?

This package contains a property for translating filament resources and models from translation files.

Once the property is installed on the resource or model, the filament navigations and pages are automatically replaced:


```php

<?php

namespace Maggomann\YourPackageFolder\Resources;

use Filament\Resources\Resource;
use Maggomann\FilamentModelTranslator\Contracts\TranslateableResources;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableResources;

class TranslateableResource extends Resource implements TranslateableResources
{
    use HasTranslateableResources;

    protected static ?string $translateableKey = 'your-package-name::';

    public function transPackageKey(): ?string
    {
        return static::$translateableKey;
    }
}

class LeagueResource extends TranslateableResource
{
    protected static ?string $model = League::class;

class FederationResource extends TranslateableResource
{
    protected static ?string $model = Federation::class;

```

### The translation file

As a sample: ```resources/lang/de/filament-model.php```

Here is an example how it could look like

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    */

    'models' => [
        'federation' => 'Verband|Verbände',
        'league' => 'Liga|Ligen',
    ],

    /*
    |--------------------------------------------------------------------------
    | Attribute
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'federation' => [
            'title' => 'Titel',
        ],
        'league' => [
            'title' => 'Titel',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    'navigation_group' => [
        'federation' => [
            'name' => 'Liegen & Turniere',
        ],
        'league' => [
            'name' => 'Liegen & Turniere',
        ],
    ],

];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
