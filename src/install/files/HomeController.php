<?php 

class HomeController extends Vis\Builder\TreeController
{
   /*
    * show index page site
    */
    public function showPage()
    {
        $page = $this->node;

        return view('pages.index', compact("page"));
    } 
}
