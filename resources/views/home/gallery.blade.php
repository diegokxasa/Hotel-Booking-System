<div class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Gallery</h2>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($gallery as $item)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="gallery_img">
                        <figure>
                            <img src="{{ asset($item->image) }}" alt="Gallery Image" class="img-fluid rounded">
                        </figure>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
