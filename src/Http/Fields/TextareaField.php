<?php

namespace Vis\Builder\Fields;

class TextareaField extends AbstractField
{
    public function isEditable()
    {
        return true;
    }

    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition['db']['table'];
        $tabs = $this->getAttribute('tabs');
        if ($tabs) {
            $field = $table.'.'.$this->getFieldName();
            $db->where(function ($query) use ($field, $value, $tabs) {
                foreach ($tabs as $tab) {
                    $query->orWhere($field.$tab['postfix'], 'LIKE', '%'.$value.'%');
                }
            });
        } else {
            $db->where($table.'.'.$this->getFieldName(), 'LIKE', '%'.$value.'%');
        }
    }

    public function getLabelClass()
    {
        return 'textarea';
    }

}
