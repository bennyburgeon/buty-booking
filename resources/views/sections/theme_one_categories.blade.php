<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-30 categories-list" data-category-id="0">
    <div class="ctg-item" style="background: var(--primary-color)">
        <a href="javascript:;">
            <div class="icon-box">
                <i class="flaticon-fork"></i>
            </div>
            <div class="content-box">
                <h5 class="mb-0">
                    @lang('front.all')
                </h5>
            </div>
        </a>
    </div>
</div>
@foreach ($categories as $category)
    @if(count($category->services))
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-30 categories-list" data-category-id="{{ $category->id }}">
            <div class="ctg-item" style="background-image:url('{{ $category->category_image_url }}')">
                <a href="javascript:;">
                    <div class="icon-box">
                        <i class="flaticon-fork"></i>
                    </div>
                    <div class="content-box">
                        <h5 class="mb-0">
                            {{ ucwords($category->name) }}
                        </h5>
                    </div>
                </a>
            </div>
        </div>
    @endif

@endforeach
