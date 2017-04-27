<?php

use Illuminate\View\View as ViewParam;

View::composer('admin::partials.navigation', function (ViewParam $view) {
    $user = Sentinel::getUser();
    $menu = config('builder.admin.menu');

    $view->with('user', $user)->with("menu", $menu);
});

View::composer(array('admin::layouts.default', 'admin::partials.scripts'), function (ViewParam $view) {

    $skin = config('skin') ? : "smart-style-4";
    $thisLang = Cookie::get("lang_admin") ? : config("builder.translate_cms.lang_default");
    $customJs = config('builder.admin.custom_js');
   
    $view->with('skin', $skin)
        ->with("thisLang", $thisLang)
        ->with("customJs", $customJs);
});

View::composer(array('admin::tree.create_modal', 'admin::tree.content'), function (ViewParam $view) {

    $templates = config('builder.' . $view->treeName. '.templates');
    $model = config('builder.' . $view->treeName. '.model');
    $idNode = request('node', 1);

    if ($idNode && $model) {
        $info = $model::find($idNode);
        if (isset($info->template)) {
            $accessTemplateShow = config('builder.' . $view->treeName. '.templates.' . $info->template. '.show_templates');

            if (count($accessTemplateShow)) {
                $accessTemplateShow = array_flip($accessTemplateShow);

                $templates = array_intersect_key($templates, $accessTemplateShow);
            }
        }
    }

    $view->with('templates', $templates);
});
