<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ERP HRM</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="login-container">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card login-card text-center">
                <div class="card-body">

                    <i class="fas fa-cube fa-4x text-primary mb-4"></i>

                    <h1 class="login-title mb-1">MASUK</h1>
                    <p class="login-subtitle mb-4">Selamat datang kembali!</p>

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger py-2" role="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="mb-3 position-relative">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="username" name="username"
                                class="form-control form-control-custom form-control-icon" placeholder="Username"
                                value="{{ old('username') }}" required>
                        </div>

                        <div class="mb-4 position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password"
                                class="form-control form-control-custom form-control-icon" placeholder="Password"
                                required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary-custom">
                                MASUK
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
