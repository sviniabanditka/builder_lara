<?php

namespace Vis\Builder\Fields;

class ReadonlyField extends AbstractField
{

    public function getEditInput($row = array())
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

    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition['db']['table'];

        if ($this->getAttribute('filter') == 'integer') {
            $db->where($table .'.'. $this->getFieldName(), $value);
            return;
        }

        $db->where($table .'.'. $this->getFieldName(), 'LIKE', '%'.$value.'%');
    }
}
