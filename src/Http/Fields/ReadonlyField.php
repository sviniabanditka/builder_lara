<?php

namespace Vis\Builder\Fields;

class ReadonlyField extends AbstractField
{

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

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) return $res;
        }

        $type = $this->getAttribute('type');
        $input = view('admin::tb.input_'. $type);
        $input->value = $this->getValue($row);
        $input->name  = $this->getFieldName();
        $input->rows  = $this->getAttribute('rows');
        $input->mask  = $this->getAttribute('mask');
        $input->custom_type  = $this->getAttribute('custom_type');

        if ( $input->name == request('foreign_field')) {
            $input->value = request('foreign_field_id');
        }

        return $input->render();
    }
}
