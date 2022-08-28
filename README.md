# This is my package filament-model-translator
Currently there is no configuration setting.

The package translates the Eloquent models using a currently specified translation file.
The Eloquent models are used internally in [filament's](https://filamentphp.com/) Resources and RelationManagers for translation. This package provides traits for the Resources and RelationManagers to translate them automatically.

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
