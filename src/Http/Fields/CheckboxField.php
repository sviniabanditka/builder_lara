<?php

namespace Vis\Builder\Fields;

use Illuminate\Support\Facades\Session;

class CheckboxField extends AbstractField
{
    public function isEditable()
    {
        return true;
    }

    public function prepareQueryValue($value)
    {
        if (! $value && $this->getAttribute('is_null')) {
            return;
        }

        return $value ? '1' : '0';
    }

    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition['db']['table'];
        $db->where($table.'.'.$this->getFieldName(), '=', $value);
    }

    public function getFilterInput()
    {
        if (! $this->getAttribute('filter')) {
            return;
        }

        $definitionName = $this->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters.'.$this->getFieldName();
        $filter = Session::get($sessionPath, '');

        $table = view('admin::tb.filter_checkbox');
        $table->filter = $filter;
        $table->name = $this->getFieldName();
        $table->options = $this->getAttribute('options');

        return $table->render();
    }

    public function getEditInput($row = [])
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }

        $table = view('admin::tb.input_checkbox');
        $table->value = $this->getValue($row);
        $table->name = $this->getFieldName();
        $table->caption = $this->getAttribute('caption');

        return $table->render();
    }

    public function getValueExport($row)
    {
        return $this->getValue($row) ? 'Да' : 'Нет';
    }

    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }

        return view('admin::tb.input_checkbox_list')->with('is_checked', $this->getValue($row));
    }

    public function getListValueFastEdit($row, $ident)
    {
        $field = $this;

        return view('admin::tb.fast_edit_checkbox', compact('row', 'ident', 'field'));
    }

    public function getValue($row, $postfix = '')
    {
        if ($this->hasCustomHandlerMethod('onGetValue')) {
            $res = $this->handler->onGetValue($this, $row, $postfix);

            if (is_int($res)) {
                return $res;
            }
        }

        $value = (
            (isset($row[$this->getFieldName()]) && $row[$this->getFieldName()]) ||
            (! isset($row[$this->getFieldName()]) && $this->getAttribute('not_checked_default') !== true)

                )
                    ? '1' : '0';

        return $value;
    }
}
