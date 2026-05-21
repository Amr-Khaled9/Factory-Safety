<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body>

    <div class="bg-shield top"></div>
    <div class="bg-shield bottom"></div>

    <div class="container">

        <div class="logo-box">
            <div class="logo">
                <i class="fa-solid fa-shield-halved"></i>
            </div>

            <h1>Login</h1>
            <p>Access your industrial safety dashboard</p>
        </div>

        <form class="login-card" method="POST" action="{{ route('web.login') }}">
            @csrf

            <div class="input-group">
                <label>Email Address</label>

                <div class="input-box">
                    <i class="fa-regular fa-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="supervisor@factory.com"
                        required>
                </div>

                @error('email')
                <small style="color:red;">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <div class="input-group">

                <div class="label-row">
                    <label>Password</label>
                </div>

                <div class="input-box">

                    <i class="fa-solid fa-lock"></i>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required>

                    <i
                        class="fa-regular fa-eye eye"
                        id="togglePassword"></i>
                </div>

                @error('password')
                <small style="color:red;">
                    {{ $message }}
                </small>
                @enderror

            </div>

            <div class="remember">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember">

                <label for="remember">
                    Remember Me
                </label>
            </div>

            <button type="submit" class="login-btn">
                Login
                <i class="fa-solid fa-arrow-right"></i>
            </button>

        </form>

        <div class="footer">
            <span>COMPLIANCE VERIFIED SYSTEM</span>

            <div class="footer-icons">
                <div class="small-icon"></div>
                <div class="small-icon active"></div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/login.js') }}"></script>

</body>

</html>