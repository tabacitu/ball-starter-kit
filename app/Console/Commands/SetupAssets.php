<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure whether to use NPM/bundling or rely solely on Basset for asset management';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Asset Management Setup');
        $this->line('This project uses Basset from Backpack for asset management, which can replace the need for NPM and bundling.');
        $this->line('');

        $useNpm = $this->confirm('Do you want to use NPM and asset bundling (Vite)?', true);

        if ($useNpm) {
            $this->info('✓ Keeping all NPM and bundling files.');
            $this->line('You can run `npm install` and `npm run dev` to set up your frontend assets.');
            return 0;
        }

        // Double-check before deletion
        $this->line('');
        $this->line('The following files will be removed:');
        $this->line('- vite.config.js');
        $this->line('- package.json');
        $this->line('- resources/js/app.js');
        $this->line('- resources/js/bootstrap.js');
        $this->line('- resources/css/app.css');
        $this->line('- node_modules (if it exists)');
        $this->line('');

        $confirmDelete = $this->confirm('Are you sure you want to remove these files?', false);

        if (!$confirmDelete) {
            $this->info('✓ Operation cancelled. All files have been kept.');
            return 0;
        }

        // Perform deletion
        $this->deleteFiles();

        $this->info('✓ NPM and bundling files have been removed.');
        $this->line('Your project will now rely solely on Basset for asset management.');
        $this->line('You can use @basset directives in your Blade templates to include assets.');

        return 0;
    }

    /**
     * Delete the unused NPM and bundling files.
     */
    protected function deleteFiles()
    {
        $filesToDelete = [
            base_path('vite.config.js'),
            base_path('package.json'),
            resource_path('js/app.js'),
            resource_path('js/bootstrap.js'),
            resource_path('css/app.css'),
        ];

        foreach ($filesToDelete as $file) {
            if (File::exists($file)) {
                File::delete($file);
                $this->line("Deleted: " . $file);
            }
        }

        // Check if node_modules exists and delete it
        $nodeModules = base_path('node_modules');
        if (File::exists($nodeModules)) {
            File::deleteDirectory($nodeModules);
            $this->line("Deleted: " . $nodeModules);
        }
    }
}
