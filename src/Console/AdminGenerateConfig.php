<?php

namespace Vis\Builder;

use Illuminate\Console\Command;

class AdminGenerateConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:generateConfig';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command generate default config file';

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
        $name = $this->ask('Database name?');

        $model = studly_case(str_singular($name));

        $fields = \DB::getSchemaBuilder()->getColumnListing($name);

        if (empty($fields)) {
            $this->error('Database not found');
            die();
        }


        $path = base_path() . '/config/builder/tb-definitions/' . $name . '.php';

        if (file_exists($path)) {
            $this->error('File exists');
            die();
        }

        $fields_config = [];

        $ignore = [
            'created_at',
            'updated_at',
        ];

        foreach ($fields as $item) {
            if ($item == 'id') {
                $fields_config[$item] = [
                    'caption' => '#',
                    'type' => 'readonly',
                    'class' => 'col-id',
                    'width' => '1%',
                    'hide' => true,
                    'is_sorting' => false,
                ];
                continue;
            }
            if ($item === 'title') {
                $fields_config[$item] = [
                    'caption' => 'Заголовок',
                    'type' => 'text',
                    'filter' => 'text',
                    'is_sorting' => true,
                    'field' => 'string',
                    'tabs' => config('translations.config.languages'),
                ];

                $ignore[] = 'title_ua';
                $ignore[] = 'title_en';

                continue;
            }

            if (in_array($item, $ignore)) {
                continue;
            }

            $fields_config[$item] = [
                'caption' => $item,
                'type' => 'text',
                'filter' => 'text',
                'is_sorting' => false,
            ];

            if (in_array($item.'_ua', $fields) || in_array($item.'_ru', $fields)) {
                $ignore[] = $item.'_ua';
                $ignore[] = $item.'_en';

                $fields_config[$item]['tabs'] = config('translations.config.languages');
            }
        }

        $default_path = base_path().'/config/builder/default.php';

        $content = file_get_contents($default_path);

        $content = str_replace_array('??', [
            $name,
            $name,
            $name,
            $model,
        ], $content);

        $content = str_replace_first("'fields_default'", var_export($fields_config, true), $content);

        $fp = fopen($path, 'w');
        fwrite($fp, $content);
        fclose($fp);
        $this->info('Success');
    }
}
