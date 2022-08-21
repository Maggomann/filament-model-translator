<?php

namespace Maggomann\FilamentModelTranslator\Commands;

use Illuminate\Console\Command;

class FilamentModelTranslatorCommand extends Command
{
    public $signature = 'filament-model-translator';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
