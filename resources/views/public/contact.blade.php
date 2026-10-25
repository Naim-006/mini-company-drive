@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')
<!-- Header Banner -->
<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">Get in Touch With Us</h1>
        <p class="lead text-white-50 mb-0">Have a project, inquiry, or question? Send us a message and we will respond promptly.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Info Cards -->
            <div class="col-lg-5">
                <h3 class="fw-bold mb-4">Contact Information</h3>
                <p class="text-secondary mb-4">
                    Reach out to our customer care or technical consulting team directly via phone, email, or visit our office.
                </p>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                                <i class="bi bi-geo-alt-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Our Location</h6>
                                <p class="text-muted small mb-0">{{ $settings->address ?? 'Corporate Office' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-success bg-opacity-10 text-success rounded-3 me-3">
                                <i class="bi bi-telephone-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Phone Number</h6>
                                <p class="text-muted small mb-0">{{ $settings->phone ?? '+1 000 000 0000' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-info bg-opacity-10 text-info rounded-3 me-3">
                                <i class="bi bi-envelope-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Email Address</h6>
                                <p class="text-muted small mb-0">{{ $settings->email ?? 'info@minicompany.test' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-warning bg-opacity-10 text-dark rounded-3 me-3">
                                <i class="bi bi-clock-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Operating Hours</h6>
                                <p class="text-muted small mb-0">{{ $settings->opening_hours ?? 'Mon - Fri: 9:00 AM - 6:00 PM' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4 p-md-5 bg-white rounded-4">
                    <h3 class="fw-bold mb-2">Send Us a Message</h3>
                    <p class="text-muted small mb-4">Fill out the form below. All inquiries are securely stored and answered by our team.</p>

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Your Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone Number <span class="text-muted small">(optional)</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 555 0199">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="subject" class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject', request('subject')) }}" placeholder="Project inquiry..." required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" placeholder="Tell us about your requirements or questions..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                            <i class="bi bi-send-fill me-2"></i> Submit Inquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
