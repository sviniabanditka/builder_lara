<?php

namespace Vis\Builder\Fields;

class SortableField extends AbstractField
{
    public $list;
    public $optionActivation;
    public $main;

    public function onSearchFilter(&$db, $value)
    {
        return null;
    }

    public function onSelectValue(&$query)
    {
        $tabs = $this->getAttribute('tabs');

        $tableName = $this->definition['db']['table'];
        $fieldName = $this->getFieldName();

        if ($tabs) {
            foreach ($tabs as $tab) {

                $name = $tableName . '.' . $this->getFieldName() . $tab['postfix'];
                $query->addSelect($name);
            }

        } else {
            $query->addSelect("$tableName.$fieldName");
        }
    }

    public function getEditInput($row = [])
    {
        $input = view('admin::tb.input_sortable');

        $input->name             = $this->getFieldName();
        $input->fieldValue       = $row[$input->name] ? explode(',', $row[$input->name]) : [];
        $input->store            = $this->getAttribute('store');
        $input->optionActivation = $this->getAttribute('option_activation', false);
        $input->is_sortable      = $this->getAttribute('is_sortable', true);
        $input->is_checked       = $this->getAttribute('is_checked', true);
        $input->main_field       = $this->getAttribute('main', false);

        $list = $this->getAttribute('list', []);

        if (is_callable($list)) {
            $list = $list($row);
        }

        $input->list = $list;

        return $input->render();
    }

    public function getListValue($row)
    {
        return false;
    }
}
