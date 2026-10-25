@extends('layouts.public')

@section('title', 'Our Services')

@section('content')
<!-- Header Banner -->
<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">Our Services & Solutions</h1>
        <p class="lead text-white-50 mb-0">Engineered to support every stage of your digital operational lifecycle.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 mb-5">
            @foreach($services as $index => $service)
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-sm p-4 bg-white rounded-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                                <i class="bi {{ $service['icon'] }} fs-3"></i>
                            </div>
                            <div>
                                <span class="badge bg-secondary-subtle text-secondary small">Service 0{{ $index + 1 }}</span>
                                <h4 class="fw-bold mb-0">{{ $service['title'] }}</h4>
                            </div>
                        </div>
                        <p class="text-secondary mb-3">{{ $service['summary'] }}</p>
                        <h6 class="fw-semibold text-dark small text-uppercase mb-2">Key Deliverables:</h6>
                        <ul class="list-unstyled mb-4 text-muted small">
                            @foreach($service['features'] as $feature)
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-auto pt-3 border-top">
                            <a href="{{ route('contact') }}?subject={{ urlencode('Inquiry regarding ' . $service['title']) }}" class="btn btn-outline-primary btn-sm">
                                Request Consultation <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Deployment Process / Workflow -->
        <div class="bg-white p-5 rounded-4 shadow-sm border">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase">How We Work</h6>
                <h3 class="fw-bold">Our 4-Step Engagement Lifecycle</h3>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="fs-1 fw-bold text-primary mb-2">01</div>
                        <h5 class="fw-bold mb-2">Discovery</h5>
                        <p class="text-muted small">We analyze your infrastructure, requirements, and business goals in detail.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="fs-1 fw-bold text-primary mb-2">02</div>
                        <h5 class="fw-bold mb-2">Architecture</h5>
                        <p class="text-muted small">We architect clean database models, scalable APIs, and secure server environments.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="fs-1 fw-bold text-primary mb-2">03</div>
                        <h5 class="fw-bold mb-2">Implementation</h5>
                        <p class="text-muted small">We write maintainable code, conduct thorough automated tests, and build modern UIs.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="fs-1 fw-bold text-primary mb-2">04</div>
                        <h5 class="fw-bold mb-2">Deployment & Support</h5>
                        <p class="text-muted small">We launch with zero downtime, configure monitoring, and provide continuous updates.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
