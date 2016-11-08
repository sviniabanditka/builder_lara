<?php namespace Vis\Builder\Helpers;

use Vis\Builder\Handlers\CustomHandler;
use Illuminate\Support\Facades\View;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;
use \Group;

class GroupsHandler extends CustomHandler
{

    public function onGetListValue($formField, array &$row)
    {
        if ($formField->getFieldName() == "permissions") {

            return View::make('admin::tb.group_access_list');
        }
    }

    public function onGetEditInput($formField, array &$row)
    {
        if ($row) {
            if ($formField->getFieldName() == 'permissions') {

                $permissions = config('builder.tb-definitions.groups.fields.permissions.permissions');
                $group = Group::find($row['id']);
                $groupPermissionsThis = $group->permissions;

                return View::make('admin::tb.group_access_list', compact('permissions', 'groupPermissionsThis'));
            }
        }
    } // end onGetEditInput

    public function onAddSelectField($field, $db)
    {
        if ($field->getFieldName() == "permissions") {
            return true;
        }
    }

    public function onUpdateRowData(array &$value, $row)
    {
        if (isset($row['permissions'])) {

            $role = Sentinel::findRoleById($row['id']);

            foreach ($row['permissions'] as $key => $permissions) {
                $permissionResult[$key] = $permissions ? true : false;
            }

            $role->permissions = $permissionResult;
            $role->save();

            unset($value['permissions']);
        }
    }

}