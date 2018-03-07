<?php

namespace Vis\Builder;

use Illuminate\Console\Command;

class CreateConfig extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:createConfig';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create config file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo 'test';
    }

}
