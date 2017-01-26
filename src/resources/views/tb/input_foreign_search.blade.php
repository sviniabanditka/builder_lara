
<input class="select2-enabled" value="3620194" type="hidden" id="{{$name}}" name="{{$name}}" style="width:100%;">

<script>
    jQuery(document).ready(function() {
        function repoFormatResult(repo) {
            var markup = '<div class="row-fluid">' +
                    '<div class="span2"><img src="' + repo.owner.avatar_url + '" /></div>' +
                    '<div class="span10">' +
                    '<div class="row-fluid">' +
                    '<div class="span6">' + repo.full_name + '</div>' +
                    '<div class="span3"><i class="fa fa-code-fork"></i> ' + repo.forks_count + '</div>' +
                    '<div class="span3"><i class="fa fa-star"></i> ' + repo.stargazers_count + '</div>' +
                    '</div>';

            if (repo.description) {
                markup += '<div>' + repo.description + '</div>';
            }

            markup += '</div></div>';

            return markup;
        }
        function repoFormatSelection(repo) {
            return repo;
            return repo.data;
        }

        var $select2{{$name}} = jQuery('#{{$name}}').select2({
            placeholder: "{{ $search['placeholder'] or 'Поиск' }}",
            minimumInputLength: {{ $search['minimum_length'] or '3' }},

            ajax: {
                url: TableBuilder.options.action_url,
                dataType: 'json',
                type: 'POST',
                quietMillis: {{ $search['quiet_millis'] or '350' }},
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        limit: {{ $search['per_page'] or '20' }}, // page size
                        page: page, // page number
                        ident: '{!! $name !!}',
                        query_type: 'many_to_many_ajax_search',
                    };
                },
                results: function (data, page) {
                    return data;
                }
            },
            initSelection: function(element, callback) {
                // the input tag has a value attribute preloaded that points to a preselected repository's id
                // this function resolves that id attribute to an object that select2 can render
                // using its formatResult renderer - that way the repository name is shown preselected
                var id = $(element).val();
                if (id !== "") {
                    callback("ee");
                }
            },
            formatResult: repoFormatResult, // omitted for brevity, see the source of this page
            formatSelection: repoFormatSelection,
            dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
        });

        @if ($selected != '[]')

            <?
             $optionss[] = array(
                    'id' => $selected,
                    'name'  => '«Ощадний»'
                );
            ?>
          $select2{{$name}}.select2("data", [{"id":1,"name": "\u0410\u043a\u0446\u0438\u044f"}]);
        @endif
    });
</script>