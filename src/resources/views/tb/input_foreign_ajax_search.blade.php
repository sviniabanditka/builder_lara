<label class="input">
    <input value="" type="text" name="{{ $name }}" class="form-control input-sm unselectable {{ $name }}_foreign">
</label>
<div style="padding-top: 4px"><a onclick="deleteForeing{{$name}}()">Удалить</a></div>

<script>
    var $select2{{$name}} = jQuery('.{{$name}}_foreign').select2({
        placeholder: "{{ $search['placeholder'] or 'Поиск' }}",
        minimumInputLength: {{ $search['minimum_length'] or '3' }},
        language: "ru",
        ajax: {
            url: TableBuilder.options.action_url,
            dataType: 'json',
            type: 'POST',
            quietMillis: {{ $search['quiet_millis'] or '350' }},
            data: function (term, page) {
                return {
                    q: term,
                    limit: {{ $search['per_page'] or '20' }},
                    page: page,
                    ident: '{!! $name !!}',
                    query_type: 'foreign_ajax_search',
                };
            },
            results: function (data, page) {
              
                return data;
            }
        },
        formatResult: function(item) {
            return item.name;
        },
        formatSelection: function(item) {
            return item.name;
        },
        formatNoMatches : function () {
            return 'По результату поиска ничего не найдено';
        },
        formatSearching: function () { return "Ищет..."; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Введите еще " + n + "   символ "; },

        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
    });

    @if ($selected)
        $select2{{$name}}.select2("data", {!! json_encode($selected) !!});
    @endif

    function deleteForeing{{$name}}() {
        $select2{{$name}}.select2("data", '');
    }

</script>