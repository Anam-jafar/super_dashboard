         <!DOCTYPE html>
         <html lang="ms">

         <head>
             <meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
             <title>MAIS</title>
             <script src="https://cdn.tailwindcss.com"></script>
             <style>
                 .bg-gradient-custom {
                     background: linear-gradient(135deg, rgb(15, 24, 124) 0%, rgb(0, 5, 22) 100%);
                 }
             </style>
         </head>

         <body class="min-h-screen">
             <div class="flex min-h-screen">
                 <!-- Left side - hidden on mobile -->
                 <div class="hidden md:flex md:w-8/12 bg-gradient-custom text-white flex-col items-center justify-center relative p-8"
                     style="background-image: url('{{ asset('assets/icons/background.png') }}'); background-size: cover; background-position: center;">

                     <div class="max-w-2xl mx-auto text-center space-y-4">
                         <h2 class="text-2xl mb-4 text-[#202947]">Selamat Datang</h2>
                         <h1 class="text-4xl font-bold leading-tight text-[#202947]">
                             Smart Masjid <br />
                             Management (MAIS)<br />
                         </h1>

                         <img src="{{ asset('assets/icons/fin_logo.svg') }}" alt="Financial Graph"
                             class="w-[12rem] mx-auto my-8" />

                         <p class="text-xl text-[#202947]">Pantau Laporan Kewangan Institusi Dengan Mudah</p>

                     </div>
                 </div>

                 <!-- Right side -->
                 <div class="w-full md:w-4/12 p-8 flex flex-col">
                     <div class="min-h-[85vh]">
                         <div class="flex justify-center items-center mb-4">
                             <label for="language" class="sr-only">Select Language</label>
                             <select id="language" name="language"
                                 class="w-28 p-1 text-gray-700 bg-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-center"
                                 onchange="location = this.value;">
                                 <option value="?lang=bm">🇲🇾 BM</option>
                                 <option value="?lang=en">🇬🇧 EN</option>
                             </select>
                         </div>


                         <div class="text-center text-blue-600 text-[1.125rem] font-medium mb-8">
                             <span>{{ $arabicDateTime }}</span><br />
                             <span>{{ $englishDateTime }}</span><br />
                         </div>
                         <div class="flex justify-center mb-8">
                             <img src="{{ asset('assets/icons/fin_logo.svg') }}" alt="MAIS Logo"
                                 class="h-[7.5rem] w-auto" />
                         </div>


                         <div class="max-w-sm mx-auto w-full">
                             <h2 class="text-center text-[1rem] font-bold mb-8">Log Masuk</h2>
                             <x-alert />
                             <form class="space-y-4" action="{{ route('submit.login') }}" method="POST">
                                 @csrf
                                 <input type="text" placeholder="Masukkan IC" name='ic'
                                     class="w-full h-[3rem] px-4 py-2 border !border-[#6E829F] rounded-lg !text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
                                 <input type="password" placeholder="Masukkan Kata Laluan" name='pass'
                                     class="w-full h-[3rem] px-4 py-2 border !border-[#6E829F] rounded-lg !text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />

                                 <div class="text-center">
                                     {{-- <a href="{{ route('forgetPassword') }}" class="text-red-500 text-sm font-semibold">Lupa Kata --}}
                                     <a href=# class="text-red-500 text-sm font-semibold">Lupa Kata
                                         Laluan?</a>
                                 </div>

                                 <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                                     <button
                                         class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                         type="submit">
                                         Log Masuk
                                     </button>
                                 </div>
                             </form>


                         </div>
                     </div>
                     <div class="mt-8 text-center">
                         <a href="{{ route('login') }}" class="text-[#5C67F7] flex items-center justify-center gap-2">
                             {{-- <img src="{{ asset('assets/icons/fin_eos_admin.svg') }}" alt="Admin" class="w-18 h-18" /> --}}
                             Log masuk sebagai pengguna </a>
                     </div>

                     <div class="mt-2 text-center text-sm text-gray-600 flex items-center justify-center gap-2">
                         <img src="{{ asset('assets/icons/fin_logo_tiny.svg') }}" alt="Admin" class="w-18 h-18" />
                         <span>Hakcipta terpelihara oleh Majlis Agama Islam Selangor (MAIS)</span>
                     </div>
                 </div>
             </div>
         </body>

         </html>
