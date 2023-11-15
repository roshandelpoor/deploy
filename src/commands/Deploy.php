<?php

namespace Roshandelpoor\Deploy\commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class Deploy extends Command
{
    protected $signature = 'deploy';
    protected $description = 'run view:clear And view:cache cache:clear And config:cache And optimize command';

    private $composer;

    public function __construct()
    {
        parent::__construct();
        $this->composer = app()['composer'];
    }

    public function handle()
    {
        echo "\n\n";
        $this->info("|-------------------------------------------------|");
        $this->info("|------------- Deploy Version 1.2.0 --------------|");
        $this->info("|-------------------------------------------------|");
        $this->warn('Notice ::');
        $this->warn('Dont worry about error [ chmod: cannot access ] in localhost');
        echo "\n\n";

        system('composer dump-autoload -o');
        $this->composer->dumpOptimized();
        $this->info("Run composer dump-autoload -o");

        $artisanPatch = str_replace('/public', '', public_path()) . '/artisan';
        system("echo 'yes' | php " . $artisanPatch . " key:generate");
        $this->info("key:generate Command Finish");

        // DELETE bootstrap/cache/
        Artisan::call('cache:clear');
        $this->info("cache:clear Command Finish");

        Artisan::call('clear-compiled');
        $this->info("clear-compiled Command Finish");

        Artisan::call('view:clear');
        $this->info("view:clear Command Finish");

        Artisan::call('route:clear');
        $this->info("route:clear Command Finish");
        Artisan::call('route:cache');
        $this->info("route:cache Command Finish");

        Artisan::call('config:clear');
        $this->info("config:clear Command Finish");
        Artisan::call('config:cache');
        $this->info("config:cache Command Finish");

        Artisan::call('optimize', ['--quiet' => true]);
        $this->info("optimize --quiet --force Command Finish");

        Artisan::call('queue:restart');
        $this->info("queue:restart Command Finish");

        $this->info("Run composer dump-autoload");
        system('composer dump-autoload');

        system("php artisan storage:link");
        $this->info("storage:link Command Finish");

        system('composer dump-autoload -o');
        $this->composer->dumpOptimized();
        $this->info("Run composer dump-autoload -o");

        $this->info("RUN chmod For Directory ...");

        if(!Config::get("app.debug")){
            $this->info("Run Command [ find . -type d -exec chmod 755 {} \;&& find . -type f -exec chmod 644 {} \; ]");
            system('find . -type d -exec chmod 755 {} \;&& find . -type f -exec chmod 644 {} \;');
        }

        $this->info("Run Command [ chown -Rf apache:apache storage && chown -Rf apache:apache bootstrap/cache ]");
        system('chmod -R apache:apache storage && chown -R apache:apache bootstrap/cache');

        $this->info("Run Command [ chmod -R 777 storage && chmod -R 777 bootstrap/cache ]");
        system('chmod -R 777 storage && chmod -R 777 bootstrap/cache');

        # for download logs
        if (!file_exists(public_path('app/logs/'))) {
            mkdir(public_path('app/logs/'), 0777, true);
        }
        system('chmod -R 777 ' . public_path('app'));
        system('chmod -R 777 ' . public_path('app/logs'));
        system('chmod -R 777 ' . public_path('app/logs/'));
        system('chmod -R 777 ' . storage_path('logs/'));

        /*if(config("app.app_on_server") == true){
            $this->info("Run Command [ tail -f " . storage_path() . "/logs/laravel-" . date('Y-m-d') . ".log ]");
            system('tail -f ' . storage_path() . '/logs/register-' . date('Y-m-d') . '.log');
        }*/

        echo "\n\n";
        $this->info("|-------------------------------------------------|");
        $this->info("|---------------- Finish ALL STEPS ---------------|");
        $this->info("|-------------------------------------------------|");
        echo "\n\n";

        return true;
    }
}
