<div class="smart-form" style="padding: 0 20px">
    <div class="row filter_gallary_images" style="padding-top: 10px">
        <section  class="col col-4">
            <label class="input">
                <input type="text" value="{{Input::get('q')}}" name="q" placeholder="Введите название картинки">
            </label>
        </section>
        <section class="col col-4">
            <label class="select">
                <select name="id_gallery" onchange="TableBuilder.changeGalleryAndTags($(this))">
                    <option value="">Выбрать галерею</option>
                     @foreach($galleries as $gallery)
                        <option value="{{$gallery->id}}" {{Input::get('gallary') == $gallery->id ? 'selected' : ''}}>{{$gallery->title}}</option>
                     @endforeach
                </select>
                <i></i>
            </label>
        </section>

        <section class="col col-4">
            <label class="select">
                <select name="id_tag" onchange="TableBuilder.changeGalleryAndTags($(this))">
                    <option value="">Выбрать тег</option>
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}" {{Input::get('tag') == $tag->id ? 'selected' : ''}}>{{$tag->title}}</option>
                    @endforeach
                </select>
                <i></i>
            </label>
        </section>
        <input type="hidden" value="{{Input::get('ident')}}" name="ident">
        <input type="hidden" value="{{Input::get('baseName')}}" name="baseName">

    </div>
</div>

    @forelse($list as $img)
        <div class="one_img_uploaded" onclick="TableBuilder.selectImgInStorage($(this))">
            <?php
            try {
                $imgParam = getimagesize(public_path($img->file_folder . $img->file_source));
            } catch (Exception $e) {
                $imgParam = ['', ''];
            }

            ?>

            <img src="{{glide($img->file_folder . $img->file_source, ['w'=>100, 'h' => 100])}}"
                 title="{{$imgParam[0].'x'.$imgParam[1]}}"
                 data-path = '{{trim($img->file_folder.$img->file_source, '/')}}'>
        </div>
    @empty
        <div style="text-align: center; padding: 50px">Нет изображений</div>
    @endforelse
    <div style="text-align: center" class="paginator_pictures">
        {{ $list->appends(Input::all())->links() }}
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
        $('[name=q]').keyup(function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);

            if (code==13) {
                e.preventDefault();
                TableBuilder.changeGalleryAndTags($('.filter_gallary_images [name=q]'));
            }
        });
    </script>
