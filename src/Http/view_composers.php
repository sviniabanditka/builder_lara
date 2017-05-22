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


View::composer(array('admin::tree.partials.update',
                     'admin::tree.partials.preview',
                     'admin::tree.partials.clone',
                     'admin::tree.partials.revisions',
                     'admin::tree.partials.delete',
                     'admin::tree.partials.constructor'
), function (ViewParam $view) {

     $type = $view->getData()['type'];
     $active = false;
     $caption = '';

    //check present config in template file
   if (config("builder." .$view->treeName.".templates.".$view->item->template.".node_definition")) {
      $update = config("builder.tb-definitions." .$view->treeName.".".$view->item->template.".actions." . $type);
      if ($update) {
          $pathToConfig = "builder.tb-definitions." .$view->treeName.".".$view->item->template.".actions." . $type;
      }
   }

    //check in main file config
   if (!isset($update) || !$update) {
       $pathToConfig = 'builder.' . $view->treeName . '.actions.' . $type;
       $update = config('builder.' . $view->treeName . '.actions.' . $type);
   }

   if ($update) {
       $caption = config($pathToConfig . '.caption');
       $checkFunction = config($pathToConfig. '.check');
       $active = $checkFunction && $checkFunction();
   }

    $view->with('active', $active)
        ->with('caption', $caption);

});