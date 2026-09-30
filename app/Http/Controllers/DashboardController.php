<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use App\Models\Document;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalBlogs' => Blog::count(),
            'totalReports' => Document::count(),
            'totalComplaints' => ContactMessage::count(),
            'recentBlogs' => Blog::latest()->take(5)->get(),
            'recentComplaints' => ContactMessage::latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }
}
