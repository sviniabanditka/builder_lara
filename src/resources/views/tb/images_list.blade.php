@if (count($list))
    @foreach($list as $img)
        <?php
          $baseImg =  basename($img);
          $imgParam = getimagesize(public_path('storage/editor/fotos/'. basename($img)));
        ?>

        <div class="one_img_uploaded" onclick="TableBuilder.selectImgInStorage($(this))">
            <img src="{{glide('/storage/editor/fotos/'. $baseImg, ['w'=>100, 'h' => 100])}}"
                 data-path = 'storage/editor/fotos/{{$baseImg}}'
                 title="{{$imgParam[0].'x'.$imgParam[1]}}"
            >
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