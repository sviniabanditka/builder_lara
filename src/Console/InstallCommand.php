<?php namespace Vis\Builder;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for install base version cms';

    private $installPath;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->installPath = __DIR__ . '/../install';;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if ($this->confirm('Start install? [y|n]')) {
            $this->sqlDumpLoad();
            $this->createFolderMinifyCssJs();
            $this->loadFiles();
            $this->publishConfigs();

            $this->finishInstall();
        }
    }

    /*
     * load table sql
     */
    private function sqlDumpLoad()
    {
        $dumpFiles = scandir($this->installPath . '/dump_sql_table/');
        foreach ($dumpFiles as $file) {
            if (preg_match('/\.(sql)/', $file)) {
                DB::unprepared(file_get_contents($this->installPath . '/dump_sql_table/' . $file));
                $this->info("Table created " . $file);
            }
        }
    }

    /*
     * create folder public/js/builds and public/css/builds
     */
    private function createFolderMinifyCssJs()
    {
        if (!is_dir(public_path() . '/css/builds')) {
            File::makeDirectory(public_path() . '/css/builds', 0777, true);
            $this->info('Folder /css/builds is created');
        }
        if (!is_dir(public_path() . '/js/builds')) {
            File::makeDirectory(public_path() . '/js/builds', 0777, true);
            $this->info('Folder /js/builds is created');
        }
    }

    /*
     * load and replace basic files
     */
    private function loadFiles()
    {
        copy( $this->installPath . '/files/.htaccess', public_path() . '/.htaccess');
        $this->info('Replace htaccess - OK');

        copy( $this->installPath . '/files/app.php', config_path() . '/app.php');
        $this->info('Replace app.php - OK');

        File::makeDirectory(app_path() . '/Models', 0777, true);
        $this->info('Folder app/Models is created');

        copy( $this->installPath . '/files/app.php', config_path() . '/app.php');
        $this->info('Replace app.php - OK');

        copy( $this->installPath . '/files/BaseModel.php', app_path() . '/Models/BaseModel.php');
        $this->info('Created app/Models/BaseModel.php - OK');

        copy( $this->installPath . '/files/Tree.php', app_path() . '/Models/Tree.php');
        $this->info('Created app/Models/Tree.php - OK');

        copy( $this->installPath . '/files/Articles.php', app_path() . '/Models/Articles.php');
        $this->info('Created app/Models/Articles.php - OK');

        copy( $this->installPath . '/files/routes.php', app_path() . '/Http/routes.php');
        $this->info('Created app/Http/routes.php - OK');

        copy( $this->installPath . '/files/composer.json', base_path() . '/composer.json');
        $this->info('Replace composer.json - OK');

        exec("composer dump-autoload");
    }

    /*
     * published all configs file
     */
    private function publishConfigs()
    {
        $this->call('vendor:publish');
    }

    /*
     * call cache:clear and other commands
     */
    private function finishInstall()
    {
        exec("composer dump-autoload");
        $this->info('composer dump-autoload completed');

        $this->call('cache:clear');
        $this->call('clear-compiled');
        $this->call('optimize');
    }

}