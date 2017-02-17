<?php namespace Vis\Builder;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Vis\Builder\Helpers\URLify;

class Jarboe
{
    protected $controller;
    protected $default;

    protected function onInit($options)
    {
        $this->controller = new JarboeController($options);
    }

    protected function onFinish()
    {
        Config::set('view.pagination', $this->default['pagination']);
        Config::set('database.fetch', $this->default['fetch']);
    }

    public function table($options)
    {
        $this->onInit($options);
        $result = $this->controller->handle();

        return $result;
    }

    public function checkNavigationPermissions()
    {
        $menu = new NavigationMenu();
        $menu->checkPermissions();
    }

    public function urlify($string)
    {
        return URLify::filter($string);
    }

    public function tree(
        $model = 'Vis\Builder\Tree',
        $options = array(),
        $nameTree = "tree"
    ) {
        $controller = new TreeCatalogController($model, $options, $nameTree);

        return $controller;
    }
}
