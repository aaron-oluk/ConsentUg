@extends('dashboard.main')
@section('title', 'Blog Management - Consent Uganda')
@section('content')
    <div class="dash-page-header">
        <div>
            <h1>Blog management</h1>
            <p>Create, preview, and update blog posts. Author is set from your logged-in account.</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBlogModal">
            <i class='bx bx-plus'></i> Create new blog
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show dash-alert" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show dash-alert" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover dash-table mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $blog)
                            <tr>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->author }}</td>
                                <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button
                                            class="btn btn-sm btn-outline-secondary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewBlogModal{{ $blog->id }}"
                                        >
                                            <i class='bx bx-show'></i> View
                                        </button>
                                        <button
                                            class="btn btn-sm btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editBlogModal{{ $blog->id }}"
                                        >
                                            <i class='bx bx-edit-alt'></i> Edit
                                        </button>
                                        <form
                                            action="{{ route('blogs.destroy', $blog->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this blog?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class='bx bx-trash'></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No blog posts found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Create Blog Modal --}}
    <div class="modal fade" id="createBlogModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new blog post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="create_title" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_content" class="form-label">Content</label>
                            <textarea class="form-control" id="create_content" name="content" rows="8" required>{{ old('content') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="create_author" class="form-label">Author</label>
                            <input
                                type="text"
                                class="form-control"
                                id="create_author"
                                value="{{ Auth::user()->name }}"
                                readonly
                                disabled
                            >
                            <div class="form-text">Author is set automatically from your logged-in account.</div>
                        </div>
                        <div class="mb-3">
                            <label for="create_image" class="form-label">Featured image</label>
                            <input type="file" class="form-control" id="create_image" name="image" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create blog post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($blogs as $blog)
        {{-- View Blog Modal --}}
        <div class="modal fade" id="viewBlogModal{{ $blog->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View blog post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($blog->image)
                            <img
                                src="{{ asset('storage/blog-images/' . $blog->image) }}"
                                alt="{{ $blog->title }}"
                                class="img-fluid rounded mb-3 w-100"
                                style="max-height: 320px; object-fit: cover;"
                            >
                        @endif

                        <h3 class="mb-2">{{ $blog->title }}</h3>
                        <p class="text-muted mb-3">
                            By {{ $blog->author }}
                            <span class="mx-2">•</span>
                            {{ $blog->created_at->format('M d, Y') }}
                        </p>

                        <div class="blog-view-content">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">
                            <i class='bx bx-link-external'></i> Open public page
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                            data-bs-toggle="modal"
                            data-bs-target="#editBlogModal{{ $blog->id }}"
                        >
                            <i class='bx bx-edit-alt'></i> Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Blog Modal --}}
        <div class="modal fade" id="editBlogModal{{ $blog->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit blog post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Current featured image</label>
                                @if ($blog->image)
                                    <div class="border rounded p-2 bg-light">
                                        <img
                                            src="{{ asset('storage/blog-images/' . $blog->image) }}"
                                            alt="{{ $blog->title }}"
                                            class="img-fluid rounded"
                                            style="max-height: 260px; width: 100%; object-fit: cover;"
                                        >
                                    </div>
                                @else
                                    <p class="text-muted mb-0">No image uploaded.</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="edit_title_{{ $blog->id }}" class="form-label">Title</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="edit_title_{{ $blog->id }}"
                                    name="title"
                                    value="{{ old('title', $blog->title) }}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="edit_content_{{ $blog->id }}" class="form-label">Content</label>
                                <textarea
                                    class="form-control"
                                    id="edit_content_{{ $blog->id }}"
                                    name="content"
                                    rows="10"
                                    required
                                >{{ old('content', $blog->content) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit_author_{{ $blog->id }}" class="form-label">Author</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="edit_author_{{ $blog->id }}"
                                    value="{{ $blog->author }}"
                                    readonly
                                    disabled
                                >
                                <div class="form-text">Author cannot be changed after the post is created.</div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_image_{{ $blog->id }}" class="form-label">Replace featured image</label>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="edit_image_{{ $blog->id }}"
                                    name="image"
                                    accept="image/*"
                                >
                                <div class="form-text">Leave empty to keep the current image.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update blog post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
