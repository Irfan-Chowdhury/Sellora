<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakePage extends Command
{
    protected $signature = 'make:page {name}';
    protected $description = 'Generate a Blade page with folders';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = $this->argument('name'); // e.g. admin.pages.roles.index

        // Convert dot notation to folder path
        $path = resource_path('views/' . str_replace('.', '/', $name) . '.blade.php');

        // Check if file exists
        if ($this->files->exists($path)) {
            $this->error("Blade file already exists at: {$path}");
            return 1;
        }

        // Make directories if not exist
        $dir = dirname($path);
        if (! $this->files->exists($dir)) {
            $this->files->makeDirectory($dir, 0755, true);
        }

        // Create Blade file with default template
        $template = <<<BLADE

        BLADE;

        $this->files->put($path, $template);

        $this->info("Blade page created at: {$path}");
    }
}
