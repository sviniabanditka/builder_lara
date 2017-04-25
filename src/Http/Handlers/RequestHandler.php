<?php namespace Vis\Builder\Handlers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Vis\Builder\JarboeController;
use Vis\Builder\Revision;

class RequestHandler
{
    protected $controller;
    protected $definitionName;
    protected $definition;

    public function __construct(JarboeController $controller)
    {
        $this->controller = $controller;
        $this->definitionName = $controller->getOption('def_name');
        $this->definition = $controller->getDefinition();
    }

    public function handle()
    {
        if (Input::get('edit')) {
            return $this->handleShowEditFormPageAction(Input::get('edit'));
        } elseif (Input::has('make')) {
            return $this->handleShowEditFormPageAction();
        }

        switch (Input::get('query_type')) {
            case 'search':
                return $this->handleSearchAction();
                
            case 'change_order':
                return $this->handleChangeOrderAction();
                
            case 'multi_action':
                return $this->handleMultiAction();
                
            case 'multi_action_with_option':
                return $this->handleMultiActionWithOption();
            
            case 'import':
                return $this->handleImport();
                
            case 'get_import_template':
                return $this->handleImportTemplateDownload();
                
            case 'export':
                return $this->handleExport();
                
            case 'set_per_page':
                return $this->handleSetPerPageAmountAction();

            case 'show_edit_form':
                return $this->handleShowEditFormAction();

            case 'show_revisions':
                return $this->handleShowRevisionForm();

            case 'show_views_statistic':
                return $this->handleShowViewsStatisic();

            case 'return_revisions':
                return $this->handleReturnRevisions();

            case 'save_edit_form':
                return $this->handleSaveEditFormAction();

            case 'show_add_form':
                return $this->handleShowAddFormAction();

            case 'save_add_form':
                return $this->handleSaveAddFormAction();

            case 'delete_row':
                return $this->handleDeleteAction();

            case 'fast_save':
                return $this->handleFastSaveAction();

            case 'clone_record':
                return $this->handleCloneAction();

            case 'upload_photo':
                return $this->handlePhotoUpload();
            
            case 'upload_photo_wysiwyg':
                return $this->handlePhotoUploadFromWysiwyg();
                
            case 'redactor_image_upload':
                return $this->handlePhotoUploadFromWysiwygRedactor();
                
            case 'change_direction':
                return $this->handleChangeDirection();

            case 'upload_file':
                return $this->handleFileUpload();
                
            case 'many_to_many_ajax_search':
                return $this->handleManyToManyAjaxSearch();

            case 'select_with_uploaded':
                return $this->handleSelectWithUploaded();

            case 'select_with_uploaded_images':
                return $this->handleSelectWithUploadedImages();

            default:
                return $this->handleShowList();
        }
    }

    protected function handleSelectWithUploaded()
    {
        $result = $this->controller->query->getUploadedFiles();

        return Response::json($result);
    }

    protected function handleSelectWithUploadedImages()
    {
        $result = $this->controller->query->getUploadedImages();

        return Response::json($result);
    }

    protected function handleManyToManyAjaxSearch()
    {
        $query = Input::get('q');
        $limit = Input::get('limit');
        $page  = Input::get('page');
        $ident = Input::get('ident');
        
        $field = $this->controller->getField($ident);
        
        $data = $field->getAjaxSearchResult($query, $limit, $page);
        
        return Response::json($data);
    }
    
    protected function handleChangeOrderAction()
    {
        $this->controller->query->clearCache();

        parse_str(Input::get('order'), $order);
        $order = $order['sort'];

        if (Input::get('params')) {
            $params = ltrim(Input::get('params'), "?");
            parse_str($params, $paramsUrl);

            if (isset($paramsUrl['page'])) {
                $pageThisCount = $paramsUrl['page'];
                unset($paramsUrl['page']);
            } else {
                $pageThisCount = 1;
            }

            if (count($paramsUrl)>0) {
                return Response::json(array(
                    'status' => false,
                    'message' => "Ошибка. Сортировка с параметрами фильтра невозможна"
                ));
            }

        } else {
            $pageThisCount = 1;
        }

        $info = $this->definition['db']['pagination']['per_page'];

        if (is_array($info)) {

            $sessionPath = 'table_builder.' . $this->definitionName . '.per_page';
            $perPage = Session::get($sessionPath);

            if (!$perPage) {
                $keys = array_keys($info);
                $perPage = $keys[0];
            }
        } else {
            $perPage = $info;
        }

        $lowest = ($pageThisCount * $perPage) - $perPage;
        
        foreach ($order as $id) {
            ++$lowest;
            \DB::table($this->definition['db']['table'])->where('id', $id)->update(array(
                'priority' => $lowest
            ));
        }
        
        return Response::json(array(
            'status' => true
        ));
    }
    
    protected function handleMultiAction()
    {
        $type = Input::get('type');
        $action = $this->definition['multi_actions'][$type];

        $isAllowed = $action['check'];

        if (!$isAllowed()) {
            throw new \RuntimeException('Multi action not allowed: '. $type);
        }
        
        $ids = Input::get('multi_ids', array());
        $handlerClosure = $action['handle'];
        $data = $handlerClosure($ids);
        
        $data['ids'] = $ids;
        $data['is_hide_rows'] = false;

        if (isset($action['is_hide_rows'])) {
            $data['is_hide_rows'] = $action['is_hide_rows'];
        }
        
        return Response::json($data);
    }
    
    protected function handleMultiActionWithOption()
    {

        $type = Input::get('type');
        $option = Input::get('option');
        $action = $this->definition['multi_actions'][$type];
        
        $isAllowed = $action['check'];
        if (!$isAllowed()) {
            throw new \RuntimeException('Multi action not allowed: '. $type);
        }
        
        $ids = Input::get('multi_ids', array());
        $handlerClosure = $action['handle'];
        $data = $handlerClosure($ids, $option);
        
        $data['ids'] = $ids;
        $data['is_hide_rows'] = false;

        if (isset($action['is_hide_rows'])) {
            $data['is_hide_rows'] = $action['is_hide_rows'];
        }
        
        return Response::json($data);
    }
    
    protected function handleImportTemplateDownload()
    {
        $type = Input::get('type');
        $method = 'do'. ucfirst($type) .'TemplateDownload';
        
        $this->controller->import->$method();
    }
    
    protected function handleImport()
    {
        $file   = Input::file('file');
        $type   = Input::get('type');
        $method = 'doImport'. ucfirst($type);
        
        $res = $this->controller->import->$method($file);
        
        $response = array(
            'status' => $res
        );
        return Response::json($response);
    }
    
    protected function handleExport()
    {
        $type   = Input::get('type');
        $method = 'doExport'. ucfirst($type);
        $idents = array_keys(Input::get('b', array()));
        
        $this->controller->export->$method($idents);
    }

    protected function handleSetPerPageAmountAction()
    {
        $perPage = Input::get('per_page');

        $sessionPath = 'table_builder.' . $this->definitionName . '.per_page';
        Session::put($sessionPath, $perPage);
        
        $response = array(
            'url' => $this->controller->getOption('url')
        );

        return Response::json($response);
    }
    
    protected function handleChangeDirection()
    {
        $order = array(
            'direction' => Input::get('direction'),
            'field' => Input::get('field')
        );

        $sessionPath = 'table_builder.' . $this->definitionName . '.order';
        Session::put($sessionPath, $order);

        $response = array(
            'url' => $this->controller->getOption('url')
        );
        return Response::json($response);
    }
    
    protected function handleFileUpload()
    {
        $file = Input::file('file');
        $prefixPath = 'storage/files/';

        if ($this->controller->hasCustomHandlerMethod('onFileUpload')) {
            $res = $this->controller->getCustomHandler()->onFileUpload($file);
            if ($res) {
                return $res;
            }
        }
        
        $extension = $file->getClientOriginalExtension();
        $nameFile = explode(".", $file->getClientOriginalName());
        $fileName  = \Jarboe::urlify($nameFile[0]) .'.'. $extension;

        if (file_exists(public_path() . '/' . $prefixPath . $fileName)) {
            $fileName = \Jarboe::urlify($nameFile[0]) . '_' . time() . '.'. $extension;
        }
        
        $destinationPath = $prefixPath;

        $file->move($destinationPath, $fileName);

        $data = array(
            'status' => true,
            'link'   => URL::to($destinationPath . $fileName),
            'short_link' => $fileName,
            'long_link' =>  "/". $destinationPath . $fileName,
        );

        return Response::json($data);
    }
    
    protected function handlePhotoUpload()
    {
        $this->controller->query->clearCache();

        $ident = Input::get('ident');
        $file  = Input::file('image');
        $num   = Input::get('num');
        
        $field = $this->controller->getField($ident);
        
        if ($this->controller->hasCustomHandlerMethod('onPhotoUpload')) {
            $res = $this->controller->getCustomHandler()->onPhotoUpload($field, $file);
            if ($res) {
                return $res;
            }
        }
        
        $data = $field->doUpload($file);

        if ($num) {
            $data['num'] = $data;
        }
        
        return Response::json($data);
    }
    
    protected function handlePhotoUploadFromWysiwyg()
    {
        $file = Input::file('image');
        
        if ($this->controller->hasCustomHandlerMethod('onPhotoUploadFromWysiwyg')) {
            $res = $this->controller->getCustomHandler()->onPhotoUploadFromWysiwyg($file);
            if ($res) {
                return $res;
            }
        }
        
        $extension = $file->guessExtension();
        $fileName = md5_file($file->getRealPath()) .'_'. time() .'.'. $extension;

        $prefixPath = 'storage/tb-' . $this->definitionName . '/';
        $postfixPath = date ('Y') . '/' . date ('m') . '/' . date ('d') . '/';
        $destinationPath = $prefixPath . $postfixPath;
        
        $status = $file->move($destinationPath, $fileName);
        
        $data = array(
            'status' => $status,
            'link'   => URL::to($destinationPath . $fileName)
        );

        return Response::json($data);
    }
    
    protected function handlePhotoUploadFromWysiwygRedactor()
    {
        $file = Input::file('file');
        
        if ($this->controller->hasCustomHandlerMethod('onPhotoUploadFromWysiwyg')) {
            $res = $this->controller->getCustomHandler()->onPhotoUploadFromWysiwyg($file);
            if ($res) {
                return $res;
            }
        }
        
        $extension = $file->guessExtension();
        $fileName = md5_file($file->getRealPath()) .'_'. time() .'.'. $extension;

        $prefixPath = 'storage/tb-'.$this->definitionName.'/';
        $postfixPath = date('Y') .'/'. date('m') .'/'. date('d') .'/';
        $destinationPath = $prefixPath . $postfixPath;
        
        $file->move($destinationPath, $fileName);
        
        $data = array(
            'filelink'   => URL::to($destinationPath . $fileName)
        );

        return Response::json($data);
    }
    
    protected function handleDeleteAction()
    {
        $idRow = $this->getRowID();
        $this->checkEditPermission($idRow);

        $result = $this->controller->query->deleteRow($idRow);

        return Response::json($result);
    }

    protected function handleFastSaveAction()
    {
        $result = $this->controller->query->fastSave(Input::all());
        $result['status'] = "ok";

        return Response::json($result);
    }

    protected function handleCloneAction()
    {
        $idRow = $this->getRowID();
        $this->checkEditPermission($idRow);
        $result = $this->controller->query->cloneRow($idRow);

        $result['html'] = "ok";

        return Response::json($result);
    }

    protected function handleShowAddFormAction()
    {
        $result = $this->controller->view->showEditForm();

        return Response::json($result);
    }

    protected function handleSaveAddFormAction()
    {
        $result = $this->controller->query->insertRow(Input::all());
        $result['html'] = $this->controller->view->getRowHtml($result);

        return Response::json($result);
    }

    protected function handleSaveEditFormAction()
    {
        $idRow = $this->getRowID();
        $this->checkEditPermission($idRow);

        $result = $this->controller->query->updateRow(Input::all());
        $result['html'] = $this->controller->view->getRowHtml($result);

        return Response::json($result);
    }

    protected function handleShowEditFormAction()
    {
        $idRow = $this->getRowID();
        $this->checkEditPermission($idRow);

        $html = $this->controller->view->showEditForm($idRow);
        $data = array(
            'html' => $html,
            'status' => true
        );

        return Response::json($data);
    }

    protected function handleShowRevisionForm()
    {
        $idRow = $this->getRowID();
        $this->checkEditPermission($idRow);

        $html = $this->controller->view->showRevisionForm($idRow);
        $data = array(
            'html' => $html,
            'status' => true
        );

        return Response::json($data);
    }

    protected function handleShowViewsStatisic()
    {
        $idRow = $this->getRowID();
        $this->checkEditPermission($idRow);

        $html = $this->controller->view->showViewsStatistic($idRow);
        $data = array(
            'html' => $html,
            'status' => true
        );

        return Response::json($data);
    }

    protected function handleReturnRevisions()
    {
        $idRevision = Input::get("id");
        $thisRevision = Revision::find($idRevision);

        $model = $thisRevision->revisionable_type;
        $key = $thisRevision->key;
        $modelObject = $model::find($thisRevision->revisionable_id);
        $modelObject->$key = $thisRevision->old_value;
        $modelObject->save();

        $data = array(
            'status' => true
        );

        return Response::json($data);
    }

    protected function checkEditPermission($id)
    {
        
    }

    private function getRowID()
    {
        if (Input::has('id')) {
            return Input::get('id');
        }
        throw new \RuntimeException("Undefined row id for action.");
    }

    protected function handleShowList()
    {
        return array(
           'showList' => $this->controller->view->showList(),
        );
    }
    
    protected function handleShowEditFormPageAction($id = false)
    {
        return $this->controller->view->showEditFormPage($id);
    }

    protected function handleSearchAction()
    {
        $this->prepareSearchFilters();

        $response = array(
            'url' => $this->controller->getOption ('url') . '?catalog='
                . Input::get ('catalog')
        );
        return Response::json($response);
    }

    private function prepareSearchFilters()
    {
        $filters = Input::get('filter', array());

        $newFilters = array();
        foreach ($filters as $key => $value) {
            if (is_array($value)) {
                if (isset($value['from']) && $value['from']) {
                    $newFilters[$key]['from'] = $value['from'];
                }
                if (isset($value['to']) && $value['to']) {
                    $newFilters[$key]['to'] = $value['to'];
                }
            } else {
                if ($value || $value === '0') {
                    $newFilters[$key] = $value;
                }
            }
        }

        if ($this->controller->hasCustomHandlerMethod('onPrepareSearchFilters')) {
            $this->controller->getCustomHandler()->onPrepareSearchFilters($newFilters);
        }

        $sessionPath = 'table_builder.' . $this->definitionName . '.filters';
        Session::put($sessionPath, $newFilters);
    }
}
