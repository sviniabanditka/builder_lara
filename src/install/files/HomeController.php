<?php namespace App\Http\Controllers;

use Vis\Builder\TreeController;
use \Product;
use Illuminate\Support\Facades\Request;

class HomeController extends TreeController  {

    /*
     * show index page site
     */
    public function showPage()
    {

        $page = $this->node;
        $productsOnMainPage = Product::showOnMain();

        return view('pages.index', compact("page", "productsOnMainPage"));
    }

}