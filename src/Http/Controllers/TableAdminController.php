<?php namespace Vis\Builder;

use Vis\Builder\Facades\Jarboe as JarboeFacade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class TableAdminController extends Controller
{
    public function showTree()
    {
        $controller = JarboeFacade::tree();

        return $controller->handle();
    } // end showTree

    public function showTreeOther($nameTree)
    {
        $model = Config::get('builder.' . $nameTree . '_tree.model');
        $option = [];

        $controller = JarboeFacade::tree($model, $option, $nameTree . "_tree");

        return $controller->handle();
    }

    public function handleTree()
    {
        $controller = JarboeFacade::tree();

        return $controller->process();
    } // end handleTree

    public function handleTreeOther($nameTree)
    {
        $model = Config::get('builder.' . $nameTree . '_tree.model');
        $option = [];

        $controller = JarboeFacade::tree($model, $option, $nameTree . "_tree");

        return $controller->process();
    } // end handleTree


    public function showTreeAll($nameTree)
    {
        $model = Config::get('builder.' . $nameTree . '.model');
        $actions = config('builder.' . $nameTree . '.actions.show');

        if ($actions && $actions['check']() !== true && is_array($actions['check']())) {
            $tree = $model::whereIn('id', $actions['check']())->get()->toHierarchy();
        } else {
            $tree = $model::all()->toHierarchy();
        }

        $idNode  = \Input::get('node', 1);
        $current = $model::find($idNode);

        $parentIDs = array();
        foreach ($current->getAncestors() as $anc) {
            $parentIDs[] = $anc->id;
        }

        return View::make('admin::tree.tree', compact("tree", "parentIDs"));
    }

    public function showPage($page)
    {
        $options = array(
            'url'      => '/admin/'.$page,
            'def_name' => $page,
        );

        $table = JarboeFacade::table($options)['showList'];

        return View::make('admin::table', compact('table'));
    }

    public function showPagePost($page)
    {
        $options = array(
            'url'      => '/admin/'.$page,
            'def_name' => $page,
        );
      
        return JarboeFacade::table($options)['showList'];
    }

    public function handlePage($page)
    {
        $options = array(
            'url'      => '/admin/'.$page,
            'def_name' => $page,
        );
        
        return JarboeFacade::table($options);
    } // end handleСases


    public function showPageUrlTree($slug = '')
    {

        $arrSegments = explode("/", $slug);
        $slug = end($arrSegments);

        if ($slug === '' || $slug == LaravelLocalization::setLocale()) {
            $slug = "/";
        }

        $_model = Config::get('builder.tree.model');
        $nodes = $_model::where("slug", 'like', $slug)->get();
        $templates = Config::get('builder.tree.templates');
    
        //check correctly url
        if (count($nodes)) {
            foreach ($nodes as $node) {

                if ($node->getUrl() == Request::url()) {
                    break;
                }
            }
        } else {
            App::abort(404);
        }

        //check is active
        if (!$node->is_active && Input::get('show') != 1) {
            App::abort(404);
        }

        if ($slug != '/' && $node->getUrl() != Request::url()) {
            App::abort(404);
        }

        //check isset template
        if (!isset($templates[$node->template])) {
            App::abort(404);
        }

        $def = $templates[$node->template]['node_definition'];

        $_model = Config::get("builder.tb-definitions.tree.$def.options.model");
        $node = (new $_model)->setRawAttributes($node->getAttributes());

        list($controller, $method) = explode('@', $templates[$node->template]['action']);


        if (LaravelLocalization::setLocale() == "") {
            $pathUrl = "/" . Request::path();
        } else {
            $pathUrl = Request::path();
        }

        if ($pathUrl == LaravelLocalization::setLocale() . Request::path()) {
            Session::put('currentNode', $node);
        } else {
            Session::put('currentNode', $node);
        }

        return app('App\\Http\\Controllers\\' . $controller)->init($node, $method);
    }

    public function doChangeRelationField()
    {
        $data = json_decode(htmlspecialchars_decode(Input::get('dataFieldJson')));

        $selected = Input::get('selected');

        $db = DB::table($data->foreign_table)
            ->select($data->foreign_value_field)
            ->addSelect($data->foreign_key_field);

        if (isset($data->additional_where)) {
            foreach ($data->additional_where as $key => $opt) {
                if (trim($opt->sign) == "in") {
                    $db->whereIn($key, $opt->value);
                } elseif (trim($opt->sign) == "not in") {
                    $db->whereNotIn($key, $opt->value);
                } else {
                    $db->where($key, $opt->sign, $opt->value);
                }
            }
        }

        if (isset($data->relation->foreign_field_filter) && Input::get('id')) {
            $db->where($data->relation->foreign_field_filter, Input::get('id'));
        }

        if (isset($data->orderBy)) {
            foreach ($data->orderBy as $order) {
                if (isset($order->field) && isset($order->type)) {
                    $db->orderBy($order->field, $order->type);
                }
            }
        }

        $res = $db->get();

        $options = array();
        $foreignKey = $data->foreign_key_field;
        $foreignValue = $data->foreign_value_field;
		$options['0'] = 'Без категории';
        foreach ($res as $val) {
            $val = (array) $val;
            $options[$val[$foreignKey]] = $val[$foreignValue];
        }

        return View::make('admin::tb.foreign_options', compact("options", "selected"))->render();
    }
}
