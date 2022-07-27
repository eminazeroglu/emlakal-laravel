<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class MakeResourceCommand extends Command
{
    protected $signature = 'make:custom_resource {name} {--back}';

    protected $description = 'Make an Resource Class';

    protected $files;

    protected $nameSpace = 'App\\Http\\Resources';

    protected $path = 'App\\Http\\Resources\\';

    protected $fileName = 'custom-response';

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

        $this->makeDirectory(dirname($path[0]));

        if ($back):
            if ($this->files->isDirectory($this->getSourcePath())):
                $this->files->deleteDirectory($this->getSourcePath());
                $this->info("Folder: ".$this->getSingularClassName($this->argument('name'))."  deleted");
            else:
                $this->info("Folder: ".$this->getSingularClassName($this->argument('name'))." not exits");
            endif;
        else:
            foreach ($path as $p):
                $contents = $this->getSourceFile(pathinfo($p)['filename']);
                if (!$this->files->exists($p)):
                    $this->files->put($p, $contents);
                    $this->info("File : {$p} created");
                else:
                    $this->info("File : {$p} already exits");
                endif;
            endforeach;
        endif;

    }

    public function getStubPath(): string
    {
        return base_path('/stubs/' . $this->fileName . '.stub');
    }

    public function getStubVariables($file): array
    {
        $name = $this->getSingularClassName($this->argument('name'));
        return [
            'NAMESPACE'  => $this->nameSpace . '\\' . $name,
            'CLASS_NAME' => $file,
            'PERMISSION' => str($this->argument('name'))->snake()
        ];
    }

    public function getSourceFile($file): array|bool|string
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables($file));
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

    public function getSourceFilePath(): array
    {
        $name = $this->getSingularClassName($this->argument('name'));
        return [
            base_path($this->path . $name . '\\' . $name . 'ListResource.php'),
            base_path($this->path . $name . '\\' . $name . 'TableResource.php'),
            base_path($this->path . $name . '\\' . $name . 'FormResource.php'),
        ];
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
