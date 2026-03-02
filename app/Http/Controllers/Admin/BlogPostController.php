<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('category')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('category'), fn ($q) => $q->where('blog_category_id', $request->category))
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($inner) use ($request) {
                    $inner->where('title', 'like', "%{$request->search}%")
                          ->orWhere('author_name', 'like', "%{$request->search}%");
                });
            })
            ->orderBy('created_at', 'desc');

        $posts      = $query->paginate(15)->withQueryString();
        $categories = BlogCategory::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Admin/Blog/Posts/Index', [
            'admin'      => Auth::guard('admin')->user(),
            'posts'      => $posts,
            'categories' => $categories,
            'filters'    => $request->only('status', 'category', 'search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Blog/Posts/Form', [
            'admin'      => Auth::guard('admin')->user(),
            'post'       => null,
            'categories' => BlogCategory::orderBy('sort_order')->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug'],
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['nullable', 'string'],
            'author_name'      => ['required', 'string', 'max:255'],
            'read_time'        => ['nullable', 'string', 'max:50'],
            'status'           => ['required', 'in:draft,published'],
            'is_featured'       => ['boolean'],
            'featured_image'    => ['nullable', 'image', 'max:2048'],
            'meta_title'        => ['nullable', 'string', 'max:160'],
            'meta_description'  => ['nullable', 'string', 'max:320'],
            'meta_keywords'     => ['nullable', 'string', 'max:500'],
            'og_image'          => ['nullable', 'string', 'max:500'],
            'canonical_url'     => ['nullable', 'url', 'max:500'],
        ]);

        $data['slug'] = $data['slug'] ? Str::slug($data['slug']) : BlogPost::uniqueSlug($data['title']);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('blog/images', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(BlogPost $post)
    {
        return Inertia::render('Admin/Blog/Posts/Form', [
            'admin'      => Auth::guard('admin')->user(),
            'post'       => array_merge($post->toArray(), [
                'featured_image_url' => $post->featured_image_url,
            ]),
            'categories' => BlogCategory::orderBy('sort_order')->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, BlogPost $post)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug,' . $post->id],
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['nullable', 'string'],
            'author_name'      => ['required', 'string', 'max:255'],
            'read_time'        => ['nullable', 'string', 'max:50'],
            'status'           => ['required', 'in:draft,published'],
            'is_featured'       => ['boolean'],
            'featured_image'    => ['nullable', 'image', 'max:2048'],
            'meta_title'        => ['nullable', 'string', 'max:160'],
            'meta_description'  => ['nullable', 'string', 'max:320'],
            'meta_keywords'     => ['nullable', 'string', 'max:500'],
            'og_image'          => ['nullable', 'string', 'max:500'],
            'canonical_url'     => ['nullable', 'url', 'max:500'],
        ]);

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = BlogPost::uniqueSlug($data['title'], $post->id);
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')
                ->store('blog/images', 'public');
        }

        if ($data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(BlogPost $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return back()->with('success', 'Post deleted successfully.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['image' => ['required', 'image', 'max:4096']]);

        $path = $request->file('image')->store('blog/images', 'public');

        return response()->json(['url' => asset('storage/' . $path)]);
    }
}
