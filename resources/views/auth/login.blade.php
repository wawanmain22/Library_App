<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 15px 15px 0 0;
            font-size: 24px;
        }

        .login-icon {
            font-size: 50px;
            color: #2c3e50;
            text-align: center;
            margin: 20px 0;
        }

        .btn-primary {
            background: #2c3e50;
            border: none;
            padding: 12px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background: #34495e;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
            border-color: #2c3e50;
        }

        .welcome-text {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-book-reader me-2"></i>Library App
                    </div>
                    <div class="card-body">
                        <div class="login-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <p class="welcome-text">Welcome back! Please login to your account.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <input type="email" name="email" class="form-control" required
                                    placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <input type="password" name="password" class="form-control" required
                                    placeholder="Enter your password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
