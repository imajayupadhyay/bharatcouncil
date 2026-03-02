<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('posts')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return Inertia::render('Admin/Blog/Categories/Index', [
            'admin'      => Auth::guard('admin')->user(),
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Blog/Categories/Form', [
            'admin'    => Auth::guard('admin')->user(),
            'category' => null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:blog_categories,slug'],
            'description' => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug']       = $data['slug'] ? Str::slug($data['slug']) : BlogCategory::uniqueSlug($data['name']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        BlogCategory::create($data);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(BlogCategory $category)
    {
        return Inertia::render('Admin/Blog/Categories/Form', [
            'admin'    => Auth::guard('admin')->user(),
            'category' => $category,
        ]);
    }

    public function update(Request $request, BlogCategory $category)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:blog_categories,slug,' . $category->id],
            'description' => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = BlogCategory::uniqueSlug($data['name'], $category->id);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        $category->update($data);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(BlogCategory $category)
    {
        if ($category->posts()->exists()) {
            return back()->with('error', 'Cannot delete a category that has posts. Reassign or delete the posts first.');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
