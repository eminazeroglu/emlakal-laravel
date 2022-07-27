<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MakeModuleCommand extends Command
{
    protected $signature = 'make:module {name} {--back} {--seeder-item}';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $argument   = mb_convert_case($this->argument('name'), MB_CASE_LOWER, 'UTF-8');
        $name       = str_replace(' ', null, ucwords(str_replace(['-', '_'], ' ', $argument)));

        $argument = str_replace(['_', '-'], '_', str($argument)->plural()->value());

        $existsMigrationFile = collect(File::allFiles('database/migrations'))
            ->map(function ($item) {
                return pathinfo($item)['filename'];
            })
            ->filter(function ($item) use ($argument) {
                return false !== stripos($item, "create_${argument}_table");
            })->first();

        if ($existsMigrationFile && !$this->option('back')):
            $this->info("Module: ${name} exists");
        else:

            if ($this->option('back')):
                File::delete(base_path("database/migrations/" . $existsMigrationFile . '.php'));
                Artisan::call("make:custom_controller ${name} --back");
                Artisan::call("make:custom_model ${name} --back");
                Artisan::call("make:custom_request ${name} --back");
                //Artisan::call("make:custom_resource ${name} --back");
                Artisan::call("make:custom_seeder ${name} --back");
                if (!$this->option('seeder-item'))
                    Artisan::call("make:custom_factory ${name} --back");
                Artisan::call("make:service ${name} --back");
                $message = "Module: ${name} deleted";
            else:
                Artisan::call("make:migration create_${argument}_table");
                Artisan::call("make:custom_controller ${name}");
                Artisan::call("make:custom_model ${name}");
                Artisan::call("make:custom_request ${name}");
                //Artisan::call("make:custom_resource ${name}");
                if ($this->option('seeder-item')):
                    Artisan::call("make:custom_seeder ${name}");
                else:
                    Artisan::call("make:custom_seeder ${name} --factory");
                    Artisan::call("make:custom_factory ${name}");
                endif;
                Artisan::call("make:service ${name}");
                $message = "Module: ${name} created";
            endif;
            $this->info($message);
        endif;
    }
}
