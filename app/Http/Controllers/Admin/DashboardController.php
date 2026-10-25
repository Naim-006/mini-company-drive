<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\ContactMessage;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard summary.
     */
    public function index(): View
    {
        $settings = CompanySetting::current();

        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'total_inquiries' => ContactMessage::count(),
            'unread_inquiries' => ContactMessage::where('is_read', false)->count(),
        ];

        $recentProducts = Product::latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('settings', 'stats', 'recentProducts', 'recentMessages'));
    }
}
