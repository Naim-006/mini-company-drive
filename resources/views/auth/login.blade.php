@extends('layouts.public')

@section('title', 'Admin Login')

@section('content')
<section class="py-5 my-md-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-dark text-white text-center py-4 border-0">
                        <div class="p-3 bg-primary bg-opacity-25 rounded-circle d-inline-flex mb-2">
                            <i class="bi bi-shield-lock-fill fs-2 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Admin Authentication</h4>
                        <p class="text-white-50 small mb-0">Sign in to access Mini Company Manager</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('login.submit') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', 'admin@example.com') }}" required autofocus>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                                <label class="form-check-label small text-secondary" for="remember">Keep me logged in on this browser</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Log In to Dashboard
                            </button>
                        </form>

                        <!-- Demo Credentials Box -->
                        <div class="mt-4 p-3 bg-light rounded-3 border">
                            <div class="small fw-bold text-dark mb-1"><i class="bi bi-info-circle-fill text-primary me-1"></i> Demo Admin Account:</div>
                            <div class="small text-muted"><strong>Email:</strong> admin@example.com</div>
                            <div class="small text-muted"><strong>Password:</strong> password</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
