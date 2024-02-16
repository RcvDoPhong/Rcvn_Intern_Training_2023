<div class="page_header">
    <div class="breadcrumbs">
        <ul>
            <li><a href="{{ route('frontend.home.index') }}">Home</a></li>
            <li><a href="{{ route('frontend.category.index') }}">Category</a></li>
            <li>{{ $pageActive }}</li>
        </ul>
    </div>
    @if (isset($title))
        <h1>{{ $title }}</h1>
    @endif
</div>
