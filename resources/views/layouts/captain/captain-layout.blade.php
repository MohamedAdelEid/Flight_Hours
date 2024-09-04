<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourly - Travel agancy</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

    <!-- custom css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/captain/style.css') }}">

    {{-- flowbit cdn style --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />

    <!-- link font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@100..900&display=swap" rel="stylesheet">

    @stack('style')
</head>

<body id="top">

    <!--#HEADER -->

    <header class="header" data-header>

        <div class="overlay" data-overlay></div>

        <div class="header-top">
            <div class="container">

                <div class="header-btn-group">

                    <button class="nav-open-btn" aria-label="Open Menu" data-nav-open-btn>
                        <ion-icon name="menu-outline"></ion-icon>
                    </button>

                </div>

                <a href="#" class="logo">
                    <img src="{{ asset('assets/imgs/main/logo-white.png') }}">
                </a>


            </div>
        </div>

        <div class="header-bottom">
            <div class="container">

                <nav class="navbar" data-navbar>

                    <div class="navbar-top">

                        <a href="#" class="logo">
                            <img src="{{ asset('assets/imgs/main/logo-white.png') }}">
                        </a>

                        <button class="nav-close-btn" aria-label="Close Menu" data-nav-close-btn>
                            <ion-icon name="close-outline"></ion-icon>
                        </button>

                    </div>

                    <ul class="navbar-list">

                        <li>
                            <a href="#home" class="navbar-link" data-nav-link>الصفحة الرئيسية</a>
                        </li>

                        <li>
                            <a href="#" class="navbar-link" data-nav-link>الرحلات</a>
                        </li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button href="#destination" class="navbar-link" data-nav-link>الصفحة الشخصية</button>
                            </form>
                        </li>


                    </ul>

                </nav>

            </div>
        </div>

    </header>

    {{ $slot }}

    </article>
    </main>


    <!-- #GO TO TOP -->
    <a href="#top" class="go-top" data-go-top>
        <ion-icon name="chevron-up-outline"></ion-icon>
    </a>


    <!-- custom js link -->
    <script src="{{ asset('assets/js/captain/script.js') }}"></script>

    {{-- ionicons link --}}
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    {{-- flowbit cdn script --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    {{-- tailwind cdn --}}
    <script src="https://cdn.tailwindcss.com"></script>

</body>

</html>
