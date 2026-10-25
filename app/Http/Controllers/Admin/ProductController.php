<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\CompanySetting;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products for the admin.
     */
    public function index(Request $request): View
    {
        $settings = CompanySetting::current();
        $search = $request->query('search');
        $category = $request->query('category');
        $status = $request->query('status');

        $query = Product::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Product::distinct()->pluck('category');

        return view('admin.products.index', compact('settings', 'products', 'categories', 'search', 'category', 'status'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $settings = CompanySetting::current();
        $categories = ['Software', 'Cloud Services', 'Consulting', 'Hardware', 'Training', 'General'];

        return view('admin.products.create', compact('settings', 'categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Generate unique slug
        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }
        $data['slug'] = $slug;

        // Handle safe image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('products', 'public');
            $data['image_path'] = $path;
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_featured'] = $request->boolean('is_featured', false);

        $product = Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Product '{$product->name}' was successfully created.");
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $settings = CompanySetting::current();
        $categories = ['Software', 'Cloud Services', 'Consulting', 'Hardware', 'Training', 'General'];

        return view('admin.products.edit', compact('settings', 'product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        // Update slug if name has changed
        if ($data['name'] !== $product->name) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $data['slug'] = $slug;
        }

        // Handle safe image replacement
        if ($request->hasFile('image')) {
            // Delete old image if present
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $file = $request->file('image');
            $path = $file->store('products', 'public');
            $data['image_path'] = $path;
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Product '{$product->name}' was successfully updated.");
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;

        // Safely remove associated image from public storage
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Product '{$name}' was deleted successfully.");
    }
}
