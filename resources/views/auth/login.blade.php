<!DOCTYPE html>
<html dir="rtl">

<head>
    @include('components.theme-init')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تسجيل الدخول</title>


    <!-- link tailwind output -->
    <link rel="stylesheet" href=" {{ asset('assets/css/admin/tailwind.output.css') }} " />

    <!-- link tailwind -->
    <link rel="stylesheet" href=" {{ asset('assets/css/admin/tailwind.css') }} " />

    <!-- link style -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}" />

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- include link font Tajwal "arabic"-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">

    <!-- include link font "english"-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Concert+One&family=Seymour+One&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">

    {{-- include font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body style='font-family: "Tajawal", sans-serif' class="login-page">

    <button type="button" class="theme-toggle theme-toggle--floating" id="login-theme-toggle" aria-label="تبديل الوضع" title="تبديل الوضع">
        <svg class="theme-toggle__icon theme-toggle__icon--sun" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <svg class="theme-toggle__icon theme-toggle__icon--moon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
        </svg>
    </button>

    <div class="login vh-100">
        <div class="d-block d-lg-flex d-xl-flex h-100 w-100">

            <div class="col-lg-6 col-xl-7 h-100">
                <div class="d-flex align-items-center justify-content-center p-5 h-100">

                    <div class="content-login">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="text-center mb-5">
                                <p class="welcome">welcome to</p>
                                <p class="logo">FLIGHT <span>HOURS</span></p>
                            </div>

                            {{-- email --}}
                            <div class="mb-3">
                                <label for="email" class="label">البريد الالكتروني</label>
                                <input type="email" id="email" value="{{ old("email") }}" name="email" class="input" required>
                                @error('email')
                                    <div class="alert alert-danger">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            {{-- password --}}
                            <div class="position-relative">
                                <label for="password" class="label">كلمة المرور</label>
                                <input type="password" id="password" name="password" class="input auth__password"
                                    required>
                                <span class="password__icon">
                                    <i class="text-primary fs-6 fw-bold fa-solid fa-eye-slash eye cursor-pointer"></i>
                                </span>
                                @error('password')
                                    <div class="alert alert-danger">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <a href="" class="forget-password">هل نسيت كلمة السر ؟ </a>

                            <button type="submit" class="primary-btn w-100 mt-4">تسجيل الدخول</button>
                        </form>
                    </div>

                </div>
            </div>

            <div class="images-login col-lg-6 col-xl-5 d-none d-lg-block d-xl-block" dir="ltr">
                <div class="w-100 h-100 d-flex align-items-center">
                    <div class="slider">
                        <div class="list">
                            <div class="item">
                                <img src="{{ asset('assets/imgs/login/login-1.png') }}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/imgs/login/login-2.png') }}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/imgs/login/login-3.png') }}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/imgs/login/login-4.png') }}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/imgs/login/login-5.png') }}" alt="">
                            </div>
                        </div>
                        <div class="buttons">
                            <button id="prev">
                                < </button>
                                    <button id="next">></button>
                        </div>
                        <ul class="dots">
                            <li class="active"></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
    (function () {
        var btn = document.getElementById('login-theme-toggle');
        if (!btn || !window.FlightHoursTheme) return;

        function syncIcons() {
            var dark = document.documentElement.classList.contains('dark');
            btn.querySelector('.theme-toggle__icon--sun').style.display = dark ? 'block' : 'none';
            btn.querySelector('.theme-toggle__icon--moon').style.display = dark ? 'none' : 'block';
        }

        syncIcons();
        btn.addEventListener('click', function () {
            window.FlightHoursTheme.toggle();
            syncIcons();
        });
    })();
    </script>

</body>

</html>
