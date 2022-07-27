<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class MakeModelCommand extends Command
{
    protected $signature = 'make:custom_model {name} {--back}';

    protected $description = 'Make an Model Class';

    protected $files;

    protected $nameSpace = 'App\\Models';

    protected $path = 'App\\Models\\';

    protected $fileName = 'custom-model';

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $back = $this->option('back');

        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();


        if ($back):
            if ($this->files->exists($path)):
                $this->files->delete($path);
                $this->info("File : {$path} deleted");
            else:
                $this->info("File : {$path} not exits");
            endif;
        else:
            if (!$this->files->exists($path)):
                $this->files->put($path, $contents);
                $this->info("File : {$path} created");
            else:
                $this->info("File : {$path} already exits");
            endif;
        endif;

    }

    public function getStubPath(): string
    {
        return base_path('/stubs/' . $this->fileName . '.stub');
    }

    public function getStubVariables(): array
    {
        $name = $this->getSingularClassName($this->argument('name'));
        return [
            'NAMESPACE'  => $this->nameSpace,
            'CLASS_NAME' => $name,
            'PERMISSION' => str($this->argument('name'))->snake()
        ];
    }

    public function getSourceFile(): array|bool|string
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }


    public function getStubContents($stub, $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;

    }

    public function getSourcePath(): string
    {
        $name = $this->getSingularClassName($this->argument('name'));
        return $this->path . $name;
    }

    public function getSourceFilePath(): string
    {
        $name = $this->getSingularClassName($this->argument('name'));
        return base_path($this->path . $name . '.php');
    }

    public function getSingularClassName($name): string
    {
        return ucwords(Pluralizer::singular($name));
    }

    protected function makeDirectory($path): string
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
