
<div class='type_6 types' {!!  isset($info->type) && $info->type==6 ? 'style="display: block"' : "" !!}>
    @if (count(config('builder.settings.langs')))
        <ul class="nav nav-tabs tabs-pull-right">
            <label class="label pull-left" style="line-height: 32px;">{{__cms('Значение')}}</label>
            @foreach(config('builder.settings.langs') as $prefix => $name)
                <li class="{{$loop->index1 == 1 ? 'active' : ''}}">
                    <a href="#etextarea_froala{{$prefix}}" data-toggle="tab">{{$name}}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content padding-5">
            @foreach(config('builder.settings.langs') as $prefix => $name)
                <?php $value = 'value' . $prefix;?>
                <div id="etextarea_froala{{$prefix}}" class="tab-pane {{$loop->index1 == 1 ? 'active' : ''}}">
                    <div style="position: relative;">
                        <label class="textarea">
                            <textarea name="value6{{$prefix}}" style="height: 250px"  placeholder="Текст {{$name}}" class="custom-scroll text_block">{{ $info->$value or "" }}</textarea>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <label class="label" >{{__cms('Значение')}}</label>
        <div style="position: relative;">
            <label class="textarea">
                <textarea name="value6" style="height: 250px" class="custom-scroll text_block">{{ $info->value or "" }}</textarea>
            </label>
        </div>
    @endif
</div>