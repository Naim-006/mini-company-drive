<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Enterprise Cloud Suite',
                'category' => 'Cloud Services',
                'price' => 199.00,
                'stock' => 50,
                'short_description' => 'Scalable multi-cloud deployment automation and monitoring platform.',
                'description' => 'The Enterprise Cloud Suite delivers instant provisioning, health checks, automated backups, and 99.99% SLA infrastructure management for modern teams.',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'CRM Pro CRM Connector',
                'category' => 'Software',
                'price' => 79.50,
                'stock' => 120,
                'short_description' => 'Synchronize leads, deals, and communication across marketing channels.',
                'description' => 'Seamless bidirectional CRM sync with email automation, pipeline visibility, and automated deal scoring.',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Smart Analytics Dashboard',
                'category' => 'Software',
                'price' => 129.00,
                'stock' => 85,
                'short_description' => 'Real-time KPI visualization, business intelligence, and exportable reports.',
                'description' => 'Connect all your data sources into an interactive real-time dashboard with alerts, role-based sharing, and automated weekly summaries.',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Security Audit & Compliance Package',
                'category' => 'Consulting',
                'price' => 499.00,
                'stock' => 20,
                'short_description' => 'Comprehensive vulnerability analysis, penetration tests, and audit reporting.',
                'description' => 'Detailed security evaluation covering web applications, APIs, server configurations, and compliance checks (SOC2, ISO27001 readiness).',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'DevOps Automation Workshop',
                'category' => 'Training',
                'price' => 249.00,
                'stock' => 30,
                'short_description' => 'Hands-on CI/CD pipeline and container orchestration training for dev teams.',
                'description' => 'An intensive guided workshop covering Docker, Kubernetes, GitHub Actions, and zero-downtime deployment strategies.',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'High-Speed IoT Gateway',
                'category' => 'Hardware',
                'price' => 349.99,
                'stock' => 45,
                'short_description' => 'Rugged industrial hardware hub for telemetry data aggregation.',
                'description' => 'Built for harsh environments with dual-band connectivity, local edge processing, encrypted transmission, and low-power consumption.',
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                $item
            );
        }
    }
}
