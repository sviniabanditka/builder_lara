<div style="position: relative" class="state-success">
    <select  multiple size="{{count($options)}}"
             name="{{ $ident }}_{{$row['id']}}"
             class="set_field_fast_edit"
             data-is-json = '{{$isJson}}'
             data-name = '{{ $ident }}'
             data-id = '{{$row['id']}}'
             onchange="TableBuilder.editFastSetField($(this))"
    >
        @foreach($options as $slug => $value)
            <option value="{{$slug}}" {{is_array($selected) && in_array($slug, $selected) ? 'selected' : ''}}>{{$value}}</option>
        @endforeach
    </select>
</div>
<script>
    /*$('[name={{ $ident }}_{{$row['id']}}]').change(function () {

        var value = {{$isJson}} ? JSON.stringify($(this).val()) : $(this).val();

        $.post( '/admin/handle/articles', {
            name: "{{ $ident }}",
            id: '{{$row['id']}}',
            value: value,
            query_type : 'fast_save'
        } );
    });*/
</script>
