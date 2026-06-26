@extends('layouts.main')
@section('title', 'Blogs')
<div class="header">
    <div class="blogs">
        <div class="container">
            <h3>Consumer Center Blogs</h3>
        </div>
    </div>
</div>
@section('body')
        <div class="row">
            @forelse ($blogs as $blog)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if ($blog->image)
                            <img src="{{ asset('storage/blog-images/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $blog->title }}</h5>
                            <p class="card-text">{{ Str::limit($blog->content, 100) }}</p>
                            <p class="card-text"><small class="text-muted">By {{ $blog->author }}</small></p>
                            <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-blog mt-auto">Read More</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>No blogs available at the moment.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-4 center">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection
