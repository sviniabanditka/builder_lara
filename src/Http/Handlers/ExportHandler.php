<?php

namespace Vis\Builder\Handlers;

use Maatwebsite\Excel\Facades\Excel;

class ExportHandler
{
    protected $def;
    protected $controller;
    protected $model;

    public function __construct(array $exportDefinition, &$controller)
    {
        $this->def = $exportDefinition;
        $this->controller = $controller;
        $this->model = $this->controller->getModel();
    }

    public function fetch()
    {
        $def = $this->def;
        if (! $this->def || ! $this->def['check']()) {
            return '';
        }

        $fields = [];
        foreach ($this->controller->getFields() as $field) {
            if ($field->getFieldName() == 'password') {
                continue;
            }

            $fields[$field->getFieldName()] = $field->getAttribute('caption');
        }

        if (isset($this->def['handle']['list'])) {
            $listHandler = $this->def['handle']['list'];
            $listHandler($fields);
        }

        return view('admin::tb.export_buttons', compact('def', 'fields'));
    }

    public function doExport($type)
    {
        $fieldsCaptions = $this->getFieldsCaptions();
        $fieldsBody = $this->getFieldsBody();

        Excel::create($this->controller->getTable(), function ($excel) use ($fieldsCaptions, $fieldsBody) {
            $excel->sheet('Sheetname', function ($sheet) use ($fieldsCaptions, $fieldsBody) {
                $sheet->row(1, $fieldsCaptions);

                $sheet->row(1, function ($row) {
                    $row->setFontWeight('bold');
                });

                $sheet->rows($fieldsBody);
            });
        })->export($type);
    }

    private function getFieldsCaptions()
    {
        foreach ($this->controller->getFields() as $field) {
            $fields[$field->getFieldName()] = $field->getAttribute('caption');
        }

        $fields = array_only($fields, array_keys(request('b')));

        return array_values($fields);
    }

    private function getFieldsBody()
    {
        $between = $this->getBetweenValues();
        $fields = request('b');

        $rows = $this->controller->query->getRows(false, true, $between, true)->toArray();
        $resultArray = [];

        foreach ($fields as $field => $value) {
            foreach ($rows as $k => $arr) {
                $resultArray[$k][$field] = isset($arr[$field]) ? $arr[$field] : '';
            }
        }

        return $resultArray;
    }

    private function getBetweenValues()
    {
        $from = request('d.from') ? request('d.from').' 00:00:01' : '1900-01-01 00:00:01';
        $to = request('d.to') ? request('d.to').' 23:59:59' : date('Y-m-d 23:59:59');

        $table = $this->controller->getDefinition()['db']['table'];

        return [
            'field' => $this->getAttribute('date_range_field') ?: $table . '.created_at',
            'values' => [
                $from, $to,
            ],
        ];
    }

    private function getAttribute($ident, $default = false)
    {
        return isset($this->def[$ident]) ? $this->def[$ident] : $default;
    }
}
