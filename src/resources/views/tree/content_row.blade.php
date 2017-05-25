<tr data-id="{{ $item->id }}">
    <td class="tb-sort-me-gently" style="cursor:s-resize;">
        <i class="fa fa-sort"></i>
    </td>
    <td>
        @if($item->isHasChilder())
            <i class="fa fa-folder"></i>
        @else
            <i class="fa fa-file-o"></i>
        @endif
        &nbsp;
            <a href="?node={{ $item->id }}" class="node_link">{{ $item->title }}</a>
    </td>
    @if(Config::get('builder.'.$treeName.'.list_fields'))

        @foreach(Config::get('builder.'.$treeName.'.list_fields') as $nameBDField => $field)

            <td>
                 @if (isset($item->$nameBDField))
                    {{strip_tags($item->$nameBDField)}}
                 @endif
            </td>

        @endforeach

    @else

        <td>
            <a class="tpl-editable" href="javascript:void(0);"
                data-type="select"
                data-name="template"
                data-pk="{{ $item->id }}"
                data-value="{{ $item->template }}"
                data-original-title="{{__cms("Выберите шаблон")}}">
                    @if (isset(Config::get('builder.'.$treeName.'.templates')[$item->template]['title']))
                        {{Config::get('builder.'.$treeName.'.templates')[$item->template]['title']}}
                    @else
                        {{ $item->template }}
                    @endif
            </a>
        </td>
        <td style="white-space: nowrap;">{{ $item->slug }}</td>
        <td style="position: relative;">
            <span class="onoffswitch">
                <input onchange="Tree.activeToggle('{{$item->id}}', this.checked);" type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" @if ($item->is_active) checked="checked" @endif id="myonoffswitch{{$item->id}}">
                <label class="onoffswitch-label" for="myonoffswitch{{$item->id}}">
                    <span class="onoffswitch-inner" data-swchon-text="{{__cms('ДА')}}" data-swchoff-text="{{__cms("НЕТ")}}"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </span>
        </td>
    @endif

    <td style="text-align: center">
       <div style="display: inline-block">
         <div class="btn-group hidden-phone pull-right">
              <a class="btn dropdown-toggle btn-default"  data-toggle="dropdown"><i class="fa fa-cog"></i> <i class="fa fa-caret-down"></i></a>

                <ul class="dropdown-menu">

                    @include('admin::tree.partials.update', ['type' => 'update'])
                    @include('admin::tree.partials.preview', ['type' => 'preview'])
                    @include('admin::tree.partials.clone', ['type' => 'clone'])
                    @include('admin::tree.partials.revisions', ['type' => 'revisions'])
                    @include('admin::tree.partials.constructor', ['type' => 'constructor'])
                  {{--  @include('admin::tree.partials.statistic', ['type' => 'statistic'])--}}
                    @include('admin::tree.partials.delete', ['type' => 'delete'])

                </ul>
         </div>
    </div>
    </td>
</tr>
