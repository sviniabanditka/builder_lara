<?php namespace Vis\Builder\Handlers;

class ButtonsHandler
{
    protected $def;
    protected $controller;

    public function __construct(array $exportDefinition, &$controller)
    {
        $this->def = $exportDefinition;
        $this->controller = $controller;
    } // end __construct

    public function fetch()
    {
        $buttons = $this->def;

        $buttonsHtml = "";
        if (count($buttons)) {
            foreach ($buttons as $button) {
                if (!$button || !$button['check']()) {
                    $buttonsHtml .= '';
                } else {
                    $buttonsHtml .= view('admin::tb.button', compact('button'));
                }
            }
        }

        return $buttonsHtml;
    }
}
