@extends('layouts.main')

@section('title', $blog->title)

<div class="header">
    <div class="contact">
        <div class="container">
            <h3>{{ $blog->title }}</h3>
        </div>
    </div>
</div>

@section('body')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="blog-post">
                    @if ($blog->image)
                        <img src="{{ asset('storage/blog-images/' . $blog->image) }}" class="img-fluid rounded mb-4"
                            alt="{{ $blog->title }}">
                    @endif

                    <h1 class="blog-post-title mb-3">{{ $blog->title }}</h1>

                    <div class="blog-post-meta text-muted mb-4">
                        <span>By {{ $blog->author }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $blog->created_at->format('M d, Y') }}</span>
                    </div>

                    <div class="blog-post-content">
                        {!! nl2br(e(str_replace('\r\n', "\n", str_replace('\r', "\n", $blog->content)))) !!}
                    </div>
                </article>

                <div class="mt-5">
                    <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                        <i class='bx bx-arrow-back'></i> Back to Blogs
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
