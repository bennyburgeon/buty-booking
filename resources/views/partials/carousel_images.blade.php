@foreach($images as $image)
    <div class="col-md-4">
        <div class="card">
            <div class="img-holder">
                <img class="card-img-top img-fluid" src="{{ $image->file_image_url }}" alt="carousel-image">
            </div>
            <div class="card-body">
                <button id="{{ $image->id }}" class="btn btn-danger pull-right delete-carousel-row">
                    @lang('app.delete')
                </button>
            </div>
        </div>
    </div>
@endforeach
