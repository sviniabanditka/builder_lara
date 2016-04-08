<script>
    jQuery(document).ready(function() {
        var $validator = jQuery("#create_form").validate({
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
                TableBuilder.doCreate();
            }
        });
    });
</script>