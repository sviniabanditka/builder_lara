
   <select class="multiselect" multiple="multiple" name="{{$name}}[]" id="{{$name}}">
        @if (isset($selected) && count($selected))
            @foreach($selected as $id => $selectOption)
                <option value="{{$id}}" selected>{{$selectOption}}</option>
            @endforeach
        @endif
        @foreach ($options as $option)
            @foreach ($option as $key => $title)
              @if (!isset($selected[$key]))
                <option value="{{$key}}">{{ trim($title) }}</option>
             @endif
            @endforeach
        @endforeach
  </select>
      
<script type="text/javascript">
    $(document).ready(function() {
      //  $.localise('ui-multiselect', {language: 'ru', path: '/packages/vis/builder/js/multiselect_master/js/locale/'});
        $(".multiselect").multiselect();

        var depended = {
            is: Boolean('{{ $depends_on && $depends_on_url }}'),
            fields: '{{ $depends_on }}',
            url:  '{{ $depends_on_url }}'
        };

        if (depended.is) {
            var $field = $('[name="' + depended.fields + '"]')
            var id = $field.parents('form').find('[name="id"]').val()

            if ($field.length) {
                $field.on('change', function (e) {
                    var $that = $(this)

                    $.ajax({
                        url: depended.url,
                        dataType: 'json',
                        data: {val: $that.val(), id: id},
                        success: function (res) {
                            if (!res.data || !Array.isArray(res.data)) {
                                TableBuilder.showErrorNotification('Ответ должен содержать data')

                                return console.log('Неправильный ответ: ', res);
                            }

                            var $select = $('#{{ $name }}')

                            $select.multiselect('destroy')

                            $select.html(' ')

                            res.data.forEach(function (option) {
                                var htmlOption = document.createElement('option')

                                htmlOption.value = option.value
                                htmlOption.text = option.text
                                htmlOption.selected = option.selected ? 'selected' : false

                                $select.append(htmlOption)
                            })

                            $select.multiselect();
                        },
                        error: function () {
                            TableBuilder.showErrorNotification('Произошла ошибка!');

                            console.log(arguments)
                        }
                    })
                });
            }
        }
    });
</script>
