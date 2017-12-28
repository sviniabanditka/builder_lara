<span class="dblclick-edit selectable element_{{ $ident }}" onclick="TableBuilder.showFastEdit(this)">{!! strip_tags($field->getListValue($row), "<a><span><img>") !!}</span>

<div class="fast-edit-buttons">
    <div class="input_field">{!! $field->getEditInput($row) !!}</div>
    <span class="fa fa-save"  onclick="TableBuilder.saveFastEdit(this, {{ $row['id'] }}, '{{ $ident }}');"></span>
    <i class="glyphicon glyphicon-remove btn-cancel" onclick="TableBuilder.closeFastEdit(this, 'cancel');"></i>
</div>