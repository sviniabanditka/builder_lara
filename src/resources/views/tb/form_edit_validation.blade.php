<script>
jQuery(document).ready(function() {
    var $validator = jQuery("#edit_form").validate({
        rules: {
            @foreach ($def['fields'] as $ident => $options)
                <?php $field = $controller->getField($ident); ?>

                {!! $field->getClientsideValidatorRules() !!}
            @endforeach
        },
        messages: {
            @foreach ($def['fields'] as $ident => $options)
                <?php $field = $controller->getField($ident); ?>

                {!! $field->getClientsideValidatorMessages() !!}
            @endforeach
        },
        submitHandler: function(form) {   

            {{ $is_tree ? 'Tree' : 'TableBuilder' }}.doEdit({{$row['id']}});
        }
    });
});   
</script>
