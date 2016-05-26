
<select name="filter[{{ $name }}]" class="form-control input-small">
    <option value=""></option>

    @if ($recursive)
        @foreach ($options as $value => $caption)
            {!!$caption!!}
        @endforeach
    @else

        @foreach ($options as $value => $caption)
            <option value="{{ $value }}" {{($caption == $selected) ? "selected" : ""}}>{{ __cms($caption) }}</option>
        @endforeach

    @endif
</select>