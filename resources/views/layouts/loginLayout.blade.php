<!DOCTYPE html>
<html lang="ms">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pendaftaran Institusi MAIS</title>
  <!-- FAVICON -->
  <link rel="icon" href="{{ asset('assets/icons/sd_logo_half.svg') }}" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Custom Styles -->
  @stack('styles')
</head>

<body>
  <div
    class="flex min-h-screen items-center justify-center bg-white p-4 lg:bg-gradient-to-t lg:from-[rgb(0,5,22)] lg:to-[rgb(15,24,124)]">
    <div class="w-full max-w-7xl space-y-8 bg-white p-2 lg:rounded-xl lg:border lg:px-20 lg:pb-10 lg:pt-20"
      style="background-image: url('{{ asset('assets/icons/background.png') }}'); background-size: cover; background-position: center;">
      @yield('content')
    </div>
  </div>
  @stack('scripts')

</body>

</html>
