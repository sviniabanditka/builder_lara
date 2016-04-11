@if(Config::get("builder.translate_cms.langs"))
    <ul class="header-dropdown-list hidden-xs">
        <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             <img alt="" src="/packages/vis/builder/img/flags/{{$thisLang == "ua" ? "ukr" : $thisLang}}.png">
             <span> {{isset(Config::get("builder.translate_cms.langs")[$thisLang]) ? Config::get("builder.translate_cms.langs")[$thisLang] : ""}} </span> <i class="fa fa-angle-down"></i> </a>
            <ul class="dropdown-menu pull-right">

              @foreach(Config::get("builder.translate_cms.langs") as $alias => $title)

                <li {{$thisLang == $alias ? "class='active'" : ""}}>
                    <a href="{{route("change_lang"). "?lang=" .$alias}}"><img src="/packages/vis/builder/img/flags/{{$alias == "ua" ? "ukr" : $alias }}.png"> {{$title}}</a>
                </li>
              @endforeach

            </ul>
        </li>
    </ul>
@endif