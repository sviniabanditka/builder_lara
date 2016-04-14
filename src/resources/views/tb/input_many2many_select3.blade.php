
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
    });
</script>