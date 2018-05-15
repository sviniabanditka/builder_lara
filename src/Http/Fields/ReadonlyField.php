<?php

namespace Vis\Builder\Fields;

class ReadonlyField extends AbstractField
{
    public function getEditInput($row = [])
    {
        return e($this->getValue($row));
    }

    public function isReadonly()
    {
        return true;
    }

    public function isEditable()
    {
        return false;
    }
}
