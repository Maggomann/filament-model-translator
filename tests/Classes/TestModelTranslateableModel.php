<?php

namespace Maggomann\FilamentModelTranslator\Tests\Classes;

use Illuminate\Database\Eloquent\Model;
use Maggomann\FilamentModelTranslator\Traits\HasTranslateableModel;

class TestModelTranslateableModel extends Model
{
    use HasTranslateableModel;

    public $timestamps = false;

    protected static ?string $translateablePackageKey = '';
}
