<?php

namespace Vis\Builder\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FindAndCheckUrlForTree
{
    private $model;

    public function getRoute($arrSegments)
    {
        $this->model = config('builder.tree.model', 'App\Models\Tree');

        $slug = $this->getSlug($arrSegments);

        $node = $this->findUrl($slug);

        if (! $node) {
            return false;
        }

        return $this->getControllerAndMethod($node);
    }

    private function getSlug($arrSegments)
    {
        $slug = end($arrSegments);

        if (! $slug || $slug == LaravelLocalization::setLocale()) {
            $slug = '/';
        }

        return $slug;
    }

    private function findUrl($slug)
    {
        $tagsCache = config('builder.tree.cache.tags', ['tree']);
        $model = $this->model;
        if (request('show') == 1) {
            $node = $model::where('slug', 'like', $slug)->orWhere('slug_en', 'like', $slug)->first();
        } else {
            $node = Cache::tags($tagsCache)->rememberForever('tree_slug_'.$slug, function () use ($model, $slug) {
                return $model::where('slug', 'like', $slug)->orWhere('slug_en', 'like', $slug)->active()->first();
            });
            if (!$node || empty($node) || count($node) == 0) {
                $node = $model::where('slug', 'like', $slug)->orWhere('slug_en', 'like', $slug)->active()->first();
            }
        }
        return $node;
    }

    private function getControllerAndMethod($node)
    {
        $templates = config('builder.tree.templates');

        if (! isset($templates[$node->template])) {
            return false;
        }

        $controllerAndMethod = explode('@', $templates[$node->template]['action']);

        $app = app();
        $controller = $app->make('App\\Http\\Controllers\\'.$controllerAndMethod[0]);

        return [
           'controller' => $controller,
           'method' => $controllerAndMethod[1],
           'node' => $node,
       ];
    }
}
