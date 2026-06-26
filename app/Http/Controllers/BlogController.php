<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // Display all blogs for public view
    public function index()
    {
        $blogs = Blog::latest()->simplePaginate(6);
        return view('blog', compact('blogs'));
    }

    // Display single blog post
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.show', compact('blog'));
    }

    // Display blogs in dashboard
    public function dashboard()
    {
        $blogs = Blog::latest()->get();
        return view('dashboard.blogs', compact('blogs'));
    }

    // Store new blog post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required|string|max:255',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->storeAs('blog-images', $imageName, 'public');

        Blog::create([
            'title' => $request->title,
            'content' => str_replace(['\r\n', '\r'], "\n", $request->content),
            'image' => $imageName,
            'author' => auth()->user()->name,
        ]);

        return redirect()->route('dashboard.blogs')
            ->with('success', 'Blog post created successfully.');
    }

    // Update blog post
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required|string|max:255',
        ]);

        $data = [
            'title' => $request->title,
            'content' => str_replace(['\r\n', '\r'], "\n", $request->content),
            'author' => $request->author,
        ];

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete('blog-images/' . $blog->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('blog-images', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $blog->update($data);

        return redirect()->route('dashboard.blogs')
            ->with('success', 'Blog post updated successfully.');
    }

    // Delete blog post
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image) {
            Storage::disk('public')->delete('blog-images/' . $blog->image);
        }

        $blog->delete();

        return redirect()->route('dashboard.blogs')
            ->with('success', 'Blog post deleted successfully.');
    }
}
