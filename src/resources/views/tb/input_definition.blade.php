<div>
    <button class="btn btn-sm btn-success" type="button"
            onclick="ForeignDefinition.createDefinition($(this), '{{$table}}', '{{$attributes}}', {{request('id')}})" id="{{$name}}">Добавить</button>
    <div class="loader_create_definition hide loader_definition_{{$name}}"></div>

    <div class="definition_blocks definition_{{$name}}">
        <p style="text-align: center">Загрузка..</p>
    </div>
    <script>
        ForeignDefinition.callbackForeignDefinition('{{request('id')}}', '{!! $attributes !!}');
    </script>
</div>