<td style="text-align: left;">
    <a onclick="Settings.getEdit({{$el->id}})">{{$el->title}}</a>
</td>
<td><span class="select_text">setting('{{$el->slug}}')</span></td>
<td>{{__cms(Config::get('builder.settings.type')[$el->type])}}</td>
<td>{{__cms(isset(Config::get('builder.settings.groups')[$el->group_type])? Config::get('builder.settings.groups')[$el->group_type] : "")}}</td>
<td>
  @if($el->type==1 || $el->type==6)
        <a onclick="Settings.getEdit({{$el->id}})">{{__cms('Текстовое поле')}}</a>
  @elseif($el->type==2)
        <a onclick="Settings.getEdit({{$el->id}})">{{__cms('Список')}}</a>
  @elseif($el->type==3)
        <a onclick="Settings.getEdit({{$el->id}})">{{__cms('Двойной список')}} </a>
   @elseif($el->type==5)
         <a onclick="Settings.getEdit({{$el->id}})">{{__cms('Тройной список')}}</a>
  @elseif($el->type==4)
        <a href="{{$el->value}}" target="_blank">{{basename($el->value)}}</a>
  @elseif($el->type==7)
      <span class="dblclick-edit selectable element_title" onclick="TableBuilder.showFastEdit(this)">
      @if ($el->value == 1)
            <span class="glyphicon glyphicon-ok"></span>
      @else
            <span class="glyphicon glyphicon-minus"></span>
      @endif
      </span>

          <div class="fast-edit-buttons">
              <div class="input_field">
                  <div class="div_input">
                      <div class="input_content smart-form input_content_toggle">

                          <label class="toggle">

                              <input type="checkbox" {{$el->value == 1 ? "checked" : ""}} value="1" name="title_{{$el->id}}">
                              <i data-swchoff-text="ВЫКЛ" data-swchon-text="ВКЛ"></i>
                          </label>

                      </div>
                  </div>
              </div>
              <span class="fa fa-save" onclick="Settings.saveFastEdit(this, {{$el->id}});"></span>
              <i class="glyphicon glyphicon-remove btn-cancel" onclick="TableBuilder.closeFastEdit(this, 'cancel');"></i>
          </div>

  @else
        <span class="dblclick-edit selectable element_title" onclick="TableBuilder.showFastEdit(this)">{{$el->value}}</span>
        <div class="fast-edit-buttons">
            <div class="input_field">
                <div class="div_input">
                    <div class="input_content">
                        <label class="input">
                            <input class="dblclick-edit-input form-control input-sm unselectable settings_fast_edit_input" value="{{$el->value}}" name="title_{{$el->id}}" type="text" placeholder="Введите значение" >
                        </label>
                    </div>
                </div>
            </div>
            <span class="fa fa-save" onclick="Settings.saveFastEdit(this, {{$el->id}});"></span>
            <i class="glyphicon glyphicon-remove btn-cancel" onclick="TableBuilder.closeFastEdit(this, 'cancel');"></i>
        </div>
  @endif
</td>
<td>
 <div style="display: inline-block">
    <div class="btn-group hidden-phone pull-right">
        <a class="btn dropdown-toggle btn-default"  data-toggle="dropdown"><i class="fa fa-cog"></i> <i class="fa fa-caret-down"></i></a>
        <ul class="dropdown-menu pull-right" id_rec ="{{$el->id}}">
             <li>
                <a class="edit_record" onclick="Settings.getEdit({{$el->id}})"><i class="fa fa-pencil"></i> {{__cms('Редактировать')}}</a>
             </li>
        </ul>
    </div>
  </div>
</td>