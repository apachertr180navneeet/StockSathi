<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Register | StockSathi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/boxicons/css/boxicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <div class="text-center mb-4">
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="" height="22">
                    </span>
                </a>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="text-uppercase mt-0">Register</h4>
                        <p class="text-muted">Create your account to get started</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control @error('name') is-invalid @enderror"
                                name="name" type="text" id="name" placeholder="Enter your name"
                                value="{{ old('name') }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input class="form-control @error('email') is-invalid @enderror"
                                name="email" type="email" id="email" placeholder="Enter your email"
                                value="{{ old('email') }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control @error('password') is-invalid @enderror"
                                name="password" type="password" id="password" placeholder="Enter your password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input class="form-control" name="password_confirmation"
                                type="password" id="password_confirmation" placeholder="Confirm your password">
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-primary fw-medium ms-1">Sign In</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center text-muted">
                <p>&copy; {{ date('Y') }} StockSathi. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
</body>
</html>
