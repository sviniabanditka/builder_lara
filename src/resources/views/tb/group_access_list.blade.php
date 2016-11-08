@if (isset($permissions) && count($permissions))
    @foreach($permissions as $permissionAlias => $permission)
        <p><label class="checkbox">
                <input type="checkbox" value="1" name="permissions[{{$permissionAlias}}]"
                @if (isset($groupPermissionsThis[$permissionAlias]) && $groupPermissionsThis[$permissionAlias])
                    checked
                @endif
                >
                <i></i> {{$permission}}
           </label>
        </p>
    @endforeach
@endif