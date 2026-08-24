<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BookMyTicket') }} - Login</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Stylesheet (Theme variables) -->
    <link rel="stylesheet" href="{{ asset('assets/css/software-landing.css') }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--secondary-bg);
            color: var(--text-color);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            position: relative;
            overflow-x: hidden;
            transition: background-color 0.3s;
        }

        /* Abstract glowing blobs for a premium look */
        .glowing-blob {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0) 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }
        .blob-1 {
            top: -100px;
            left: -100px;
        }
        .blob-2 {
            bottom: -100px;
            right: -100px;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 30px;
        }
        .logo-link {
            font-size: 26px;
            text-decoration: none;
            font-weight: 700;
            color: var(--text-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .logo-link span {
            color: var(--accent-blue);
        }

        /* 3D Flip Card Container */
        .login-box-new {
            position: relative;
            width: 100%;
            min-height: 520px;
            transform-style: preserve-3d;
            transition: transform 0.6s cubic-bezier(0.4, 0.2, 0.2, 1);
        }
        .login-box-new.flipped {
            transform: rotateY(180deg);
        }

        .login-card-front, .login-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 45px 35px;
            box-sizing: border-box;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: background 0.3s, border-color 0.3s, box-shadow 0.3s;
        }
        .login-card-back {
            transform: rotateY(180deg);
        }

        .login-head {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 10px;
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .login-head i {
            color: var(--accent-blue);
            font-size: 20px;
        }

        .login-subhead {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0 0 30px;
        }

        .form-group-new {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }
        .form-label-new {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .input-field-new {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--secondary-bg);
            color: var(--text-color);
            font-size: 14px;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        .input-field-new:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(0, 112, 243, 0.15);
            outline: none;
            background: var(--card-bg);
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }

        .utility-row-new {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .checkbox-wrap-new {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }
        .checkbox-wrap-new input {
            width: 16px;
            height: 16px;
            accent-color: var(--accent-blue);
            cursor: pointer;
        }

        .link-primary-new {
            color: var(--accent-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .link-primary-new:hover {
            text-decoration: underline;
        }

        .btn-submit-new {
            width: 100%;
            background: var(--accent-blue);
            color: #ffffff;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-submit-new:hover {
            background: #0060d0;
        }
        .btn-submit-new:active {
            transform: scale(0.98);
        }

        .theme-toggle-btn {
            border: 1px solid var(--border-color);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: var(--card-bg);
            color: var(--text-color);
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            transition: all 0.2s;
        }
        .theme-toggle-btn:hover {
            border-color: var(--text-muted);
            transform: scale(1.05);
        }
    </style>
</head>
<body class="light-theme">
    <!-- Immediate theme block to prevent flash -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.body.classList.remove('light-theme');
            }
        })();
    </script>

    <!-- Glowing Background blobs -->
    <div class="glowing-blob blob-1"></div>
    <div class="glowing-blob blob-2"></div>

    <!-- Theme Switcher Top Right -->
    <div style="position: absolute; top: 20px; right: 20px; z-index: 100;">
        <button id="themeToggleBtn" class="theme-toggle-btn" aria-label="Toggle Theme">
            <i class="fa-solid fa-moon"></i>
        </button>
    </div>

    <div class="login-wrapper">
        <!-- Logo -->
        <div class="logo-container">
            <a href="{{ route('software.home') }}" class="logo-link">
                <i class="fa-solid fa-ticket" style="color: var(--accent-blue);"></i> Book My<span>Ticket</span>
            </a>
        </div>

        <!-- Flip Box Container -->
        <div class="login-box-new" id="loginBox">
            
            <!-- Front Card: Sign In -->
            <div class="login-card-front">
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h3 class="login-head"><i class="fa-solid fa-user-lock"></i> SIGN IN</h3>
                    <p class="login-subhead">Sign in to manage event check-ins and ticketing operations.</p>
                    
                    <div class="form-group-new">
                        <label class="form-label-new" for="email">Email / Mobile</label>
                        <input class="input-field-new @error('email') is-invalid @enderror" type="text" id="email" value="{{ old('email') }}" name="email" placeholder="Enter your email or mobile" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group-new">
                        <label class="form-label-new" for="password">Password</label>
                        <input class="input-field-new @error('password') is-invalid @enderror" type="password" id="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="utility-row-new">
                        <label class="checkbox-wrap-new">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Stay signed in</span>
                        </label>
                        <a href="#" class="link-primary-new" data-toggle="flip">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="btn-submit-new">
                        <i class="fa-solid fa-right-to-bracket"></i> Sign In
                    </button>
                </form>
            </div>

            <!-- Back Card: Forgot Password -->
            <div class="login-card-back">
                <form class="forget-form" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <h3 class="login-head"><i class="fa-solid fa-key"></i> RESET PASSWORD</h3>
                    <p class="login-subhead">Enter your account email address to receive a secure reset link.</p>
                    
                    <div class="form-group-new">
                        <label class="form-label-new" for="reset_email">Email Address</label>
                        <input class="input-field-new @error('email') is-invalid @enderror" type="email" id="reset_email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-submit-new" style="margin-top: 15px; margin-bottom: 25px;">
                        <i class="fa-solid fa-unlock-keyhole"></i> Send Reset Link
                    </button>
                    
                    <a href="#" class="link-primary-new" data-toggle="flip" style="font-size: 14px; display: inline-flex; align-items: center; gap: 6px; justify-content: center; margin: 0 auto;">
                        <i class="fa-solid fa-arrow-left" style="font-size: 12px;"></i> Back to Login
                    </a>
                </form>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Theme toggle logic
            const themeToggleBtn = $('#themeToggleBtn');
            
            function applyTheme(theme) {
                if (theme === 'light') {
                    $('body').addClass('light-theme');
                    themeToggleBtn.find('i').removeClass('fa-sun').addClass('fa-moon');
                    localStorage.setItem('theme', 'light');
                } else {
                    $('body').removeClass('light-theme');
                    themeToggleBtn.find('i').removeClass('fa-moon').addClass('fa-sun');
                    localStorage.setItem('theme', 'dark');
                }
            }

            // Apply saved theme or default to light
            const savedTheme = localStorage.getItem('theme') || 'light';
            applyTheme(savedTheme);
            
            themeToggleBtn.click(function() {
                const isLight = $('body').hasClass('light-theme');
                applyTheme(isLight ? 'dark' : 'light');
            });

            // Flip card logic
            $('[data-toggle="flip"]').click(function(e) {
                e.preventDefault();
                $('#loginBox').toggleClass('flipped');
            });
        });
    </script>
</body>
</html>