<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallGitHooks extends Command
{
    protected $signature = 'git:install-hooks';
    protected $description = 'Install Git hooks from scripts/hooks';

    public function handle(): int
    {
        $source = base_path('scripts/hooks/pre-push');
        $destination = base_path('.git/hooks/pre-push');

        if (!file_exists($source)) {
            $this->error("❌ pre-push hook not found in scripts/hooks");
            return self::FAILURE;
        }

        if (!is_dir(base_path('.git/hooks'))) {
            $this->error("❌ .git/hooks directory does not exist");
            return self::FAILURE;
        }

        copy($source, $destination);
        chmod($destination, 0755);

        $this->info("✅ pre-push hook installed successfully.");
        return self::SUCCESS;
    }
}
