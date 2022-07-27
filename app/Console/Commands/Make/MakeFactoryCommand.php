<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class MakeFactoryCommand extends Command
{
    protected $signature = 'make:custom_factory {name} {--back}';

    protected $description = 'Make an Factory Class';

    protected $files;


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
        return base_path('/stubs/custom-factory.stub');
    }

    public function getStubVariables(): array
    {
        $name = $this->getSingularClassName($this->argument('name'));
        return [
            'NAMESPACE'  => 'Database\\Factories',
            'CLASS_NAME' => $name,
        ];
    }

    public function getSourceFile(): array|bool|string
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    public function getSourcePath(): string
    {
        $name = $this->getSingularClassName($this->argument('name'));
        return 'Database\\Factories\\' . $name;
    }

    public function getStubContents($stub, $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;

    }

    public function getSourceFilePath(): string
    {
        $name = $this->getSingularClassName($this->argument('name'));
        return base_path('Database\\Factories') . '\\' . $name . 'Factory.php';
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
