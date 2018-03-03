@if (count($list))
    @foreach($list as $img)
        <div class="one_img_uploaded" onclick="TableBuilder.selectImgInStorage($(this))">
            <img src="{{glide('/storage/editor/fotos/'. basename($img), ['w'=>100, 'h' => 100])}}" data-path = 'storage/editor/fotos/{{basename($img)}}'>
        </div>
    @endforeach

    <div style="text-align: center" class="paginator_pictures">
        {{ $list->appends(Input::all())->render() }}
    </div>

    <script>
        $(".paginator_pictures a").click(function(e) {
            var href = $(this).attr('href');
            e.preventDefault();
            var section = $(this).parents('tbody');
            $.post(href,
                function(response){
                    section.html(response.data);
                });
        });

    </script>

@endif