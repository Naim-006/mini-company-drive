@extends('layouts.public')

@section('title', 'About Us')

@section('content')
<!-- Header Banner -->
<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">About {{ $settings->company_name ?? 'Our Company' }}</h1>
        <p class="lead text-white-50 mb-0">{{ $settings->tagline ?? 'Built for innovation, reliability, and growth.' }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Story / Summary -->
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6">
                <span class="badge bg-primary-subtle text-primary fw-bold text-uppercase px-3 py-2 rounded-pill mb-2">Who We Are</span>
                <h2 class="fw-bold mb-3">Empowering organizations with smart digital technology</h2>
                <p class="text-secondary leading-relaxed mb-4">
                    {{ $settings->about_summary ?? 'We are a dedicated team of engineers, designers, and business strategists committed to delivering high-impact solutions for businesses of all sizes.' }}
                </p>
                <div class="d-flex align-items-center gap-4">
                    <div>
                        <h3 class="fw-bold text-primary mb-0">10+</h3>
                        <span class="text-muted small">Years Experience</span>
                    </div>
                    <div class="border-start ps-4">
                        <h3 class="fw-bold text-primary mb-0">500+</h3>
                        <span class="text-muted small">Projects Delivered</span>
                    </div>
                    <div class="border-start ps-4">
                        <h3 class="fw-bold text-primary mb-0">98%</h3>
                        <span class="text-muted small">Client Satisfaction</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded-4 shadow-sm border">
                    <h5 class="fw-bold mb-3"><i class="bi bi-clock-history text-primary me-2"></i> Company Overview</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-geo-alt-fill text-primary mt-1 me-3"></i>
                            <div>
                                <span class="fw-semibold d-block">Headquarters</span>
                                <span class="text-muted small">{{ $settings->address ?? 'Silicon Oasis, CA' }}</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-envelope-fill text-primary mt-1 me-3"></i>
                            <div>
                                <span class="fw-semibold d-block">General Inquiries</span>
                                <span class="text-muted small">{{ $settings->email ?? 'info@minicompany.test' }}</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-telephone-fill text-primary mt-1 me-3"></i>
                            <div>
                                <span class="fw-semibold d-block">Direct Line</span>
                                <span class="text-muted small">{{ $settings->phone ?? '+1 000 000 0000' }}</span>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="bi bi-calendar-check-fill text-primary mt-1 me-3"></i>
                            <div>
                                <span class="fw-semibold d-block">Office Schedule</span>
                                <span class="text-muted small">{{ $settings->opening_hours ?? 'Mon - Fri: 9:00 AM - 6:00 PM' }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mission & Vision Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm p-4 bg-white rounded-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-3 p-3 mb-3" style="width: 54px; height: 54px;">
                        <i class="bi bi-flag-fill fs-4"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Our Mission</h4>
                    <p class="text-muted mb-0">
                        {{ $settings->about_mission ?? 'To accelerate digital transformation through reliable, high-performance software and dedicated engineering excellence.' }}
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm p-4 bg-white rounded-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-3 p-3 mb-3" style="width: 54px; height: 54px;">
                        <i class="bi bi-eye-fill fs-4"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Our Vision</h4>
                    <p class="text-muted mb-0">
                        {{ $settings->about_vision ?? 'To become the most reliable business and software partner for small, medium, and large enterprises worldwide.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Core Values -->
        <div class="bg-white rounded-4 shadow-sm p-5 border text-center">
            <h3 class="fw-bold mb-4">Values That Guide Our Work</h3>
            <div class="row g-4 text-start">
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-shield-check text-primary fs-3 me-3"></i>
                        <div>
                            <h5 class="fw-bold mb-1">Security & Integrity</h5>
                            <p class="text-muted small">We build solutions that keep your data safe, meeting modern compliance standards and defensive coding best practices.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-lightning-charge text-warning fs-3 me-3"></i>
                        <div>
                            <h5 class="fw-bold mb-1">High Performance</h5>
                            <p class="text-muted small">Optimized code, clean database schemas, and lightweight architecture designed for responsive experiences at scale.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-people text-info fs-3 me-3"></i>
                        <div>
                            <h5 class="fw-bold mb-1">Client Centricity</h5>
                            <p class="text-muted small">We prioritize clear communication, reliable timelines, and post-launch support for every organization we serve.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
