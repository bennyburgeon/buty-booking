@if (!is_null($categories))
<section class="bg-secondary">
    <div class="container" id="all_services">
        <div class="w-100">
            <div class="heading text-center">
                <h3 class="font-weight-bold">@lang('front.our') @lang('front.categories')</h3>
                <p class="mt-0 mt-lg-2 mt-md-2 f-16 text-light">@lang('front.categoriesTitle')</p>
            </div>
        </div>
        <div class="row pt-50 justify-content-center change-category">
            <!-- START -->
            @foreach ($categories as $category)
                @if(count($category->services))
                    <div class="col-md-3 mb-24 categories-list" data-category-id="{{ $category->id }}">
                        <div class="categories position-relative">
                            <a href="{{url($category->slug.'/services')}}">
                                <figure class="effect-layla w-100">
                                    <img src="{{ $category->category_image_url }}" alt="Appointo" />
                                    <figcaption>
                                        <p>{{ ucwords($category->name) }}</p>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
            <!-- END -->
        </div>
        @if ($categories->count() === 8)
            <div class="row">
                <div class="col-md-2 mx-auto mt-3">
                    <a href="{{ route('front.cartPage') }}" class="secondary-btn btn-lg btn f-15 w-100 text-dark">
                        @lang('app.loadMore')
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endif
