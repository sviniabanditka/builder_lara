<script>
  $("#create_form_{{$def['db']['table']}}").validate({
        rules: {
            @foreach ($def['fields'] as $ident => $options)
                @set("field", $controller->getField($ident))

                {!! $field->getClientsideValidatorRules() !!}
            @endforeach
        },
        messages: {
            @foreach ($def['fields'] as $ident => $options)
                @set("field", $controller->getField($ident))

                {!! $field->getClientsideValidatorMessages() !!}
            @endforeach
        },
        submitHandler: function(form) {
            TableBuilder.doCreate("#create_form_{{$def['db']['table']}}", '{{request('foreign_field_id')}}', '{!! request('foreign_attributes') !!}');
        }
    });
</script>