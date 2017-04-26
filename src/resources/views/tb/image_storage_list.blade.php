@if (count($list))
    @foreach($list as $img)
        <div class="one_img_uploaded" onclick="TableBuilder.selectImgInStorage($(this))">
            <img src="{{glide($img['file_folder'].$img['file_source'], ['w'=>100, 'h' => 100])}}" data-path = '{{trim($img['file_folder'].$img['file_source'], '/')}}'>
        </div>
    @endforeach
@endif