<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\CompanySetting;
use App\Models\ContactMessage;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display the public home page.
     */
    public function home(): View
    {
        $settings = CompanySetting::current();
        $featuredProducts = Product::query()
            ->active()
            ->where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();

        $services = $this->getServicesList();

        return view('public.home', compact('settings', 'featuredProducts', 'services'));
    }

    /**
     * Display the public About Us page.
     */
    public function about(): View
    {
        $settings = CompanySetting::current();

        return view('public.about', compact('settings'));
    }

    /**
     * Display the public Services page.
     */
    public function services(): View
    {
        $settings = CompanySetting::current();
        $services = $this->getServicesList();

        return view('public.services', compact('settings', 'services'));
    }

    /**
     * Display the public Products catalog with search and filters.
     */
    public function products(Request $request): View
    {
        $settings = CompanySetting::current();
        $search = $request->query('search');
        $category = $request->query('category');

        $query = Product::query()->active();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        $products = $query->latest()->paginate(6)->withQueryString();
        $categories = Product::query()->active()->distinct()->pluck('category');

        return view('public.products', compact('settings', 'products', 'categories', 'search', 'category'));
    }

    /**
     * Display a single product's detail page.
     */
    public function productDetail(Product $product): View
    {
        if (! $product->is_active) {
            abort(404, 'Product not found or currently unavailable.');
        }

        $settings = CompanySetting::current();
        $relatedProducts = Product::query()
            ->active()
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->take(3)
            ->get();

        return view('public.product-detail', compact('settings', 'product', 'relatedProducts'));
    }

    /**
     * Display the public Contact Us page.
     */
    public function contact(): View
    {
        $settings = CompanySetting::current();

        return view('public.contact', compact('settings'));
    }

    /**
     * Handle incoming contact form submission.
     */
    public function sendContact(ContactRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return redirect()
            ->route('contact')
            ->with('success', 'Thank you! Your message has been received. Our team will get back to you shortly.');
    }

    /**
     * Internal helper to provide company service offerings.
     *
     * @return list<array{title: string, icon: string, summary: string, features: list<string>}>
     */
    private function getServicesList(): array
    {
        return [
            [
                'title' => 'Custom Software Engineering',
                'icon' => 'bi-code-slash',
                'summary' => 'Tailored enterprise web applications built with high standards of security, scalability, and performance.',
                'features' => ['Laravel & PHP architecture', 'RESTful API integration', 'Modern responsive UI', 'Automated testing'],
            ],
            [
                'title' => 'Cloud & Infrastructure Services',
                'icon' => 'bi-cloud-check',
                'summary' => 'Robust cloud infrastructure hosting, automated deployment pipelines, and zero-downtime management.',
                'features' => ['cPanel & VPS provisioning', 'SSL configuration', 'Automated off-site backups', 'Server performance tuning'],
            ],
            [
                'title' => 'Database Design & Optimization',
                'icon' => 'bi-database-check',
                'summary' => 'Relational database schema modeling, indexing strategies, data migration, and query optimization.',
                'features' => ['MySQL & MariaDB tuning', 'Normalized schema design', 'Data integrity controls', 'High-availability replication'],
            ],
            [
                'title' => 'IT Consultancy & Security',
                'icon' => 'bi-shield-lock',
                'summary' => 'Expert guidance to secure applications, comply with modern data policies, and eliminate vulnerabilities.',
                'features' => ['Codebase security audit', 'Vulnerability assessment', 'Role-based access control', 'Compliance checklists'],
            ],
        ];
    }
}
