<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Institusi MAIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom Styles -->
    @stack('styles')
</head>

<body>
    <div
        class="min-h-screen flex items-center justify-center p-4 bg-white lg:bg-gradient-to-t lg:from-[rgb(0,5,22)] lg:to-[rgb(15,24,124)]">
        <div class="w-full max-w-7xl p-2 lg:px-20 lg:pt-20 lg:pb-10 space-y-8 bg-white  lg:rounded-xl lg:border"
            style="background-image: url('{{ asset('assets/icons/background.png') }}'); background-size: cover; background-position: center;">
            @yield('content')
        </div>
    </div>
    @stack('scripts')

</body>

</html>
