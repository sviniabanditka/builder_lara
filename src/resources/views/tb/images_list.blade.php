@if (count($list))
    @foreach($list as $img)
        <div class="one_img_uploaded">
            <img src="{{glide('/storage/editor/fotos/'. basename($img), ['w'=>100, 'h' => 100])}}" data-path = 'storage/editor/fotos/{{basename($img)}}'>
        </div>
    @endforeach
    <script>
        $('.one_img_uploaded').click(function () {

            var type = $(this).parents('tbody').attr('data-type');

            if (type == 'one_file') {
                $(this).parents('tbody').find('.one_img_uploaded').removeClass('selected');
            }

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                $(this).addClass('selected');
            }

        });
    </script>
@endif