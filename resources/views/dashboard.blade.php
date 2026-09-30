@extends('dashboard.main')

@section('title', 'Dashboard - Consent Uganda')

@section('content')
    <div class="dash-page-header">
        <div>
            <h1>Dashboard overview</h1>
            <p>Track users, content, reports, and incoming complaints at a glance.</p>
        </div>
        <a href="{{ route('dashboard.blogs') }}" class="btn btn-primary">
            <i class='bx bx-plus'></i> New blog post
        </a>
    </div>

    <div class="stat-grid">
        <div class="stat-card users">
            <div class="stat-icon"><i class='bx bx-user'></i></div>
            <p class="stat-label">Total users</p>
            <p class="stat-value">{{ $totalUsers }}</p>
            <p class="stat-meta">Registered accounts</p>
        </div>

        <div class="stat-card blogs">
            <div class="stat-icon"><i class='bx bx-news'></i></div>
            <p class="stat-label">Blog posts</p>
            <p class="stat-value">{{ $totalBlogs }}</p>
            <p class="stat-meta">Published articles</p>
        </div>

        <div class="stat-card reports">
            <div class="stat-icon"><i class='bx bx-file'></i></div>
            <p class="stat-label">Reports</p>
            <p class="stat-value">{{ $totalReports }}</p>
            <p class="stat-meta">Uploaded documents</p>
        </div>

        <div class="stat-card complaints">
            <div class="stat-icon"><i class='bx bx-message-square-detail'></i></div>
            <p class="stat-label">Complaints</p>
            <p class="stat-value">{{ $totalComplaints }}</p>
            <p class="stat-meta">Contact submissions</p>
        </div>
    </div>

    <div class="panel-grid">
        <section class="dash-panel">
            <div class="dash-panel-header">
                <h2>Recent blog posts</h2>
                <a href="{{ route('dashboard.blogs') }}" class="btn-dash-ghost">View all</a>
            </div>
            <div class="dash-panel-body">
                <div class="table-responsive">
                    <table class="table dash-table mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentBlogs as $blog)
                                <tr>
                                    <td>{{ Str::limit($blog->title, 36) }}</td>
                                    <td>{{ $blog->author }}</td>
                                    <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state">No blog posts yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="dash-panel">
            <div class="dash-panel-header">
                <h2>Recent complaints</h2>
                <a href="{{ route('dashboard.complaints.index') }}" class="btn-dash-ghost">View all</a>
            </div>
            <div class="dash-panel-body">
                <div class="table-responsive">
                    <table class="table dash-table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentComplaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->name }}</td>
                                    <td>{{ Str::limit($complaint->message, 36) }}</td>
                                    <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state">No complaints yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
