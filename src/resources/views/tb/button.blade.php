<div class="widget-toolbar" role="menu">
    <a href="{{$button['link']}}" class="btn dropdown-toggle btn-xs btn-default"  data-toggle="dropdown">
        <i class="fa {{isset($button['icon']) && $button['icon'] ? "fa-".$button['icon'] : ""}}"></i>
        {{__cms($button['caption'])}}
    </a>
</div>