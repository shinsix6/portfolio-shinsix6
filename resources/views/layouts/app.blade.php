<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

        <style>
            * {
                font-family: "Josefin sans";
                margin: 0;
                padding: 0;
                color: white;
            }
            a {
                color: white;
                text-decoration: none;
            }

            .a-link {
                color: #58D1F3;
            }

            .a-link:hover {
                text-decoration: underline;
            }

            .a-semi {
                text-decoration: none;
                color: #7BFFAD;
            }

            .a-semi:hover {
                text-decoration: underline;
            }

            .text-indent {
                text-indent: 2em;
            }

            .bd-text {
                border-bottom: 5px solid #344150;
            }
        </style>

        @livewireStyles
    </head>
    <body style="background-color: #202023">
        <nav class="nav mt-3 w-100 d-flex flex-row mx-auto justify-content-between align-items-center" style="max-width: 750px;">
            <a href="/" wire:navigate class="d-flex flex-row gap-1 link-underline link-underline-opacity-0">
                <i class="fa-solid fa-torii-gate fs-5"></i>
                <span class="fw-bold fs-6">Shin6</span>
            </a>

            <div class="d-flex gap-4">
                <a href="/" wire:navigate class="link-underline link-underline-opacity-0 fs-6">Home</a>
                <a href="/projects" wire:navigate class="link-underline link-underline-opacity-0 fs-6">Works</a>
            </div>

            <a href="https://github.com/shinsix6" class="d-flex flex-row gap-1 link-underline link-underline-opacity-0">
                <i class="fa-brands fa-github fs-5"></i>
                <span class="fw-bold fs-6" >Github</span>
            </a>
        </nav>

        <div class="d-flex justify-content-center" style="margin-top: 7em;">
            <img src="{{ asset('assets/banner.png') }}" class="w-75" alt="banner" style="max-width: 850px;">
        </div>

        {{ $slot }}

        <footer class="mt-5 d-flex align-items-center justify-content-center">
            <p class="text-white small">@ 2026 shin6. All right reserved</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @livewireScripts
    </body>
</html>
