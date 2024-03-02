[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/Maggomann/filament-model-translator/run-tests.yml?branch%3Av0.x&label=tests)](https://github.com/Maggomann/filament-model-translator/actions?query=workflow%3Arun-tests+branch%3Av0.x) [![GitHub license](https://img.shields.io/github/license/Maggomann/filament-model-translator)](https://github.com/Maggomann/filament-model-translator/blob/v0.x/LICENSE.md) [![Total Downloads](https://img.shields.io/packagist/dt/maggomann/filament-model-translator.svg?style=flat-square)](https://packagist.org/packages/maggomann/filament-model-translator)
---

# Filament model translator package for filament v3.x

This package is tailored for [Filament Admin Panel v3.x](https://filamentphp.com/docs/3.x/admin/installation).

Make sure you have installed the admin panel before you continue with the installation. You can check the [documentation here](https://filamentphp.com/docs/3.x/admin/installation)

The package translates the Eloquent models using a currently specified translation file.
The Eloquent models are used internally in [filament's](https://filamentphp.com/docs/3.x/admin/installation) Resources and RelationManagers for translation. This package provides traits for the Resources and RelationManagers to translate them automatically.

## Supported Versions

- PHP: [`8.3`, `8.2`, `8.1`]
  - Laravel: `10.*`
- PHP: [`8.3`, `8.2`]
  - Laravel: `11.*`

## Installation

You can install the package via composer:

```console
composer require maggomann/filament-model-translator
```

Add the plugin to your desired Filament panel:

```php
use Maggomann\FilamentModelTranslator\FilamentModelTranslatorServicePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ...
            ->plugins([
                FilamentModelTranslatorServicePlugin::make()
            ]);
    }
}
```

## How is it used?

### The language files

The translations are currently called from the `filament-model.php` translation file, which must be located in the following directory tree:

```sonsole
resources
    lang
        de
            filament-model.php
        en
            filament-model.php
```

The translation file has the following content structure:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    */

    'models' => [
        'calculation_type' => 'Calculation type|Calculation types',
        'federation' => 'Association|Associations',
        'league' => 'League|Leagues',
    ],

    /*
    |--------------------------------------------------------------------------
    | Attribute
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'federation' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'calculation_type_id' => 'Calculation type',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'deleted_at' => 'Deleted at',
        ],
        'league' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'deleted_at' => 'Deleted at',
        ],
        'calculation_type' => [
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'deleted_at' => 'Deleted at',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    'navigation_group' => [
        'federation' => [
            'name' => 'Seasons & Tournaments',
        ],
        'league' => [
            'name' => 'Seasons & Tournaments',
        ],
        'calculation_type' => [
            'name' => 'Seasons & Tournaments',
        ],
    ],
];
```

### The trait HasTranslateableResources for the resource classes

The trait `HasTranslateableResources` internally translates the method calls automatically:

```php
public static function getModelLabel(): string;

public static function getPluralModelLabel(): string;

protected static function getNavigationGroup(): ?string;
```

Example:

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

Or:

```php
<?php

namespace Maggomann\YourPackageFolder\Resources;

use Filament\Resources\Resource;
use Maggomann\FilamentModelTranslator\Contracts\TranslateableResources;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableResources;

class LeagueResource  extends Resource implements TranslateableResources
{
    use HasTranslateableResources;

    protected static ?string $translateableKey = 'your-package-name::';

    public function transPackageKey(): ?string
    {
        return static::$translateableKey;
    }

    protected static ?string $model = League::class;
```

```php
<?php

namespace Maggomann\YourPackageFolder\Resources;

use Filament\Resources\Resource;
use Maggomann\FilamentModelTranslator\Contracts\TranslateableResources;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableResources;

class FederationResource extends Resource implements TranslateableResources
{
    use HasTranslateableResources;

    protected static ?string $translateableKey = 'your-package-name::';

    public function transPackageKey(): ?string
    {
        return static::$translateableKey;
    }

    protected static ?string $model = Federation::class;
```

### The trait HasTranslateableRelationManager for the relation classes

The trait `HasTranslateableRelationManager` internally translates the method calls automatically:

```php
public static function getModelLabel(): string;

public static function getPluralModelLabel(): string;
```

You can use the trait `HasTranslateableRelationManager` in the following ways:

Example:

```php
<?php

namespace Maggomann\YourPackageFolder\Resources;

use Filament\Resources\RelationManagers\RelationManager;
use Maggomann\FilamentModelTranslator\Contracts\Translateable;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableRelationManager;

class TranslateableRelationManager extends RelationManager implements Translateable
{
    use HasTranslateableRelationManager;

    protected static ?string $translateablePackageKey = 'your-package-name::';
}
```

```php
<?php

namespace Maggomann\YourPackageFolder\Resources\FederationResource\RelationManagers;


use Maggomann\YourPackageFolder\Resources\TranslateableRelationManager;

class LeaguesRelationManager extends TranslateableRelationManager
{
```

Or:

```php
<?php

namespace Maggomann\YourPackageFolder\Resources\FederationResource\RelationManagers;


use Filament\Resources\RelationManagers\RelationManager;
use Maggomann\FilamentModelTranslator\Contracts\Translateable;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableRelationManager;

class LeaguesRelationManager extends RelationManager implements Translateable
{
    use HasTranslateableRelationManager;

    protected static ?string $translateablePackageKey = 'your-package-name::';
```

### The trait HasTranslateableModel for the eloquent classes

The following method calls are available with the trait `HasTranslateableModel`:

```php
<?php
EloquentModel::ransAttribute('your_attributes_key');

// Example
TextInput::make('name')
        ->label(Federation::transAttribute('name'))
        ->required();
```

You can use the trait `HasTranslateableModel` in the following ways:

Example:

```php
<?php

namespace Maggomann\YourPackageFolder\Models;

use Illuminate\Database\Eloquent\Model;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableModel;

class TranslateableModel extends Model
{
    use HasTranslateableModel;

    protected static ?string $translateablePackageKey = 'your-package-name::';
}
```

```php
<?php

namespace Maggomann\YourPackageFolder\Models;

class Federation extends TranslateableModel
{
```

Or:

```php
<?php

namespace Maggomann\YourPackageFolder\Models;

use Illuminate\Database\Eloquent\Model;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableModel;

class Federation extends Model
{
    use HasTranslateableModel;

    protected static ?string $translateablePackageKey = 'your-package-name::';
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Marco Ehrt](https://github.com/Maggomann)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Disclaimer

**Please note that these packages for Filament are not officially operated by Filament and do not provide any support or warranty from the Filament team. The use of these packages is at your own risk.**

This project represents unofficial extensions for Filament and is maintained by an independent community of developers. We strive to maintain compatibility with the current versions of Filament, but we cannot guarantee that the packages will function flawlessly or be compatible with future versions of Filament.

We recommend users to create backups of their projects and thoroughly test them before using these packages. If you have any questions, issues, or suggestions, we are available to assist you. However, please note that we cannot provide official support for these packages.

We would like to emphasize that Filament is a separate developer community independent of this project. For more information about Filament, please refer to the official Filament website.

Please read the license terms to learn more about the conditions for using these packages.
