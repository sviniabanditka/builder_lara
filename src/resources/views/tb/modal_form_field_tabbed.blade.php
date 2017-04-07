
@foreach ($fields as $ident)
        @if (is_array($ident))
            <div class="row">
                @include('admin::tb.modal_form_field_tabbed', ['fields' => $ident])
            </div>
            @continue
        @endif
    <?php
    $options = $def['fields'][$ident];
    $field = $controller->getField($ident);
    ?>

    @if ($field->isHidden())
        @continue
    @endif

    @if (isset($options['tabs']))
        @if ($is_blank)
            {!! $field->getTabbedEditInput() !!}
        @else
            {!! $field->getTabbedEditInput($row) !!}
        @endif

        @continue
    @endif

    @if ($options['type'] == 'checkbox')
        <section class="{{$field->getAttribute('class_name') ? "section_field ".$field->getAttribute('class_name'): ""}}">
            @if ($is_blank)
                {!! $field->getEditInput() !!}
            @else
                {!! $field->getEditInput($row) !!}
            @endif
         </section>

        @continue
    @endif

    <section class="{{$field->getAttribute('class_name') ? "section_field ".$field->getAttribute('class_name'): ""}}">
        @if ($is_blank)
            @if ($options['type'] != "readonly")
             <label class="label" for="{{$ident}}">{{__cms($options['caption'])}}</label>
                <div style="position: relative;">
                    {!! $field->getEditInput() !!}
                    {!! $field->getSubActions() !!}
                </div>
            @endif
        @else
            <label class="label" for="{{$ident}}">22{{__cms($options['caption'])}}</label>
            <div style="position: relative;">
                {!! $field->getEditInput($row) !!}
                {!! $field->getSubActions() !!}
            </div>
        @endif
    </section>
@endforeach
