<?php

View::composer(array('partials.header'), function($view) {

    $menu = Cache::tags(array('products', 'tree'))->rememberForever('menuProduct', function() {
        $menu = Tree::isMenu()->get();

        return $menu;
    });

    $menuTop = Cache::tags(array('products', 'tree'))->rememberForever('menuTop', function() {
        $menuTop = Tree::isMenuTop()->get();

        return $menuTop;
    });

    $view->with('menu', $menu)
         ->with('menuTop', $menuTop);
});

View::composer(array('partials.footer'), function($view) {

    $menu = Cache::tags(array('products', 'tree'))->rememberForever('menuProduct', function() {
        $menu = Tree::isMenu()->get();

        return $menu;
    });

    $menuFooter = Cache::tags(array('products', 'tree'))->rememberForever('menuFooter', function() {
        $mmenuFooter = Tree::isMenuFooter()->get();

        return $mmenuFooter;
    });

    $view->with('menu', $menu)
        ->with('mmenuFooter', $menuFooter);
});


View::composer('partials.breadcrumbs', function($view) {

    if (!isset($view->getData()['page'])) {
        return "Не передан параметр";
    }
    $page = $view->getData()['page'];

    //if node
    if( get_class($page) == "Tree" || get_class($page) == "NewsTree") {
        $breadcrumbs = new Breadcrumbs($page);
    } else {
        $node = $page->getNode();
        $breadcrumbs = new Breadcrumbs($node);
        $breadcrumbs->add($page->getUrl(), $page->title);
    }

    $view->with('breadcrumbs', $breadcrumbs);
});