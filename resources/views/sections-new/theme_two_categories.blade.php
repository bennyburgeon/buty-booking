@foreach ($categories as $category)
    @if(count($category->services))
        <li class="nav-item">
            <a class="nav-link active" href="{{url($category->slug.'/services')}}">{{ ucWords($category->name) }}</a>
        </li>
    @endif
@endforeach
