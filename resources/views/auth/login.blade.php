<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MAIS</title>
    <link rel="icon" href="{{ asset('assets/icons/fin_logo_tiny.svg') }}" type="image/svg+xml">

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
                    Sistem Pengurusan Masjid<br />
                    (MAIS)<br />
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
                    <img src="{{ asset('assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="h-[7.5rem] w-auto" />
                </div>


                <div class="max-w-sm mx-auto w-full">
                    <h2 class="text-center text-[1rem] font-bold mb-8">Log Masuk</h2>
                    <x-alert />

                    <!-- Login Form - Completely separate -->
                    <form class="space-y-4" action="{{ route('submit.login') }}" method="POST">
                        @csrf
                        <input type="text" placeholder="Masukkan Email" name='mel'
                            class="w-full h-[3rem] px-4 py-2 border !border-[#6E829F] rounded-lg !text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
                        <input type="password" placeholder="Masukkan Kata Laluan" name='pass'
                            class="w-full h-[3rem] px-4 py-2 border !border-[#6E829F] rounded-lg !text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />

                        <div class="text-center">
                            <a href="javascript:void(0);"
                                onclick="document.getElementById('resetPasswordModal').style.display='flex'"
                                class="text-red-500 text-sm font-semibold">Lupa Kata
                                Laluan?</a>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                            <button
                                class="px-8 py-3 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition-colors w-full md:w-auto md:min-w-[200px]"
                                type="submit">
                                Log Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-2 text-center text-sm text-gray-600 flex items-center justify-center gap-2">
                <img src="{{ asset('assets/icons/fin_logo_tiny.svg') }}" alt="Admin" class="w-18 h-18" />
                <span>Hakcipta terpelihara oleh Majlis Agama Islam Selangor (MAIS)</span>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal - completely separate from the login form -->
    <div id="resetPasswordModal"
        class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 !mt-0">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full md:max-w-[60%] md:h-[70%] mx-auto text-center relative">
            <!-- Close Button -->
            <button type="button" onclick="document.getElementById('resetPasswordModal').style.display='none'"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <div class="flex justify-center mb-8">
                <img src="{{ asset('assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="h-[7.5rem] w-auto" />
            </div>
            <!-- Title -->
            <h1 class="text-xl md:text-3xl font-bold leading-tight text-[#202947]">
                LUPA KATA LALUAN
            </h1>

            <!-- Instructions -->
            <p class="text-gray-700 mb-8 text-base md:text-lg">
                Sila masukkan emel yang berdaftar untuk mendapatkan OTP
            </p>

            <!-- Email Input Form - separate from login form -->
            <div class="mb-8">
                <input type="email" id="reset_email" placeholder="Masukkan Email"
                    class="w-full md:max-w-[60%] h-[3rem] px-4 py-2 border !border-[#6E829F] rounded-lg !text-gray-800 
                    focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
            </div>

            <!-- Continue Button -->
            <div class="flex justify-center">
                <button onclick="handleContinue()" type="button"
                    class="px-8 py-3 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition-colors w-full md:w-auto md:min-w-[200px]">
                    Teruskan
                </button>
            </div>
        </div>
    </div>

    <!-- OTP Modal - completely separate from both login and reset password forms -->
    <div id="fillOtp"
        class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 !mt-0">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full md:max-w-[60%] md:h-[70%] mx-auto text-center relative">
            <!-- Close Button -->
            <button type="button" onclick="document.getElementById('fillOtp').style.display='none'"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <div class="flex justify-center mb-8">
                <img src="{{ asset('assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="h-[7.5rem] w-auto" />
            </div>

            <!-- Title -->
            <h1 class="text-xl md:text-3xl font-bold leading-tight text-indigo-500">
                LOG MASUK MENGGUNAKAN OTP
            </h1>

            <!-- Instructions -->
            <p class="text-gray-700 mb-8 text-base md:text-lg">
                Sila masukkan OTP yang diterima
            </p>

            <!-- Hidden fields for OTP verification -->
            <input type="hidden" id="user_id_hidden" value="" />
            <input type="hidden" id="otp_hidden" value="" />

            <!-- OTP Input Fields -->
            <div class="flex flex-wrap justify-center gap-2 sm:gap-4 mb-8">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    class="w-12 h-12 sm:w-16 sm:h-16 text-center text-xl bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 otp-input"
                    onkeyup="moveToNext(this, event)" />
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    class="w-12 h-12 sm:w-16 sm:h-16 text-center text-xl bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 otp-input"
                    onkeyup="moveToNext(this, event)" />
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    class="w-12 h-12 sm:w-16 sm:h-16 text-center text-xl bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 otp-input"
                    onkeyup="moveToNext(this, event)" />
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    class="w-12 h-12 sm:w-16 sm:h-16 text-center text-xl bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 otp-input"
                    onkeyup="moveToNext(this, event)" />
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    class="w-12 h-12 sm:w-16 sm:h-16 text-center text-xl bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 otp-input"
                    onkeyup="moveToNext(this, event)" />
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    class="w-12 h-12 sm:w-16 sm:h-16 text-center text-xl bg-gray-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 otp-input"
                    onkeyup="moveToNext(this, event)" />
            </div>



            <!-- Login Button -->
            <div class="flex justify-center">
                <button onclick="handleOtpLogin()" type="button"
                    class="px-8 py-3 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition-colors w-full md:w-auto md:min-w-[200px]">
                    Log Masuk
                </button>
            </div>
        </div>
    </div>

    <script>
        // Handle Continue button click in the reset password modal
        function handleContinue() {
            const emailInput = document.getElementById('reset_email');
            const email = emailInput.value.trim();

            if (!email) {
                alert('Sila masukkan alamat emel anda.');
                return;
            }

            // Show loading state
            const continueButton = document.querySelector('#resetPasswordModal button[type="button"]');
            const originalButtonText = continueButton.innerHTML;
            continueButton.innerHTML = 'Memproses...';
            continueButton.disabled = true;

            // Make AJAX request to check email and send OTP
            fetch('/mais/check-email-send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        mel: email
                    })
                })
                .then(response => response.json())
                .then(data => {
                    continueButton.innerHTML = originalButtonText;
                    continueButton.disabled = false;

                    if (data.success) {
                        // Hide reset password modal and show OTP modal
                        document.getElementById('resetPasswordModal').style.display = 'none';
                        document.getElementById('fillOtp').style.display = 'flex';

                        // Store user ID and OTP in hidden fields for verification later
                        document.getElementById('user_id_hidden').value = data.user_id;
                        document.getElementById('otp_hidden').value = data.otp;

                        // Focus on the first OTP input field
                        document.querySelector('.otp-input').focus();
                    } else {
                        alert(data.message || 'Pengguna tidak dijumpai.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    continueButton.innerHTML = originalButtonText;
                    continueButton.disabled = false;
                    alert('Ralat semasa memproses permintaan. Sila cuba lagi.');
                });
        }

        // Function to move to next OTP input field
        function moveToNext(field, event) {
            const maxLength = parseInt(field.getAttribute('maxlength'));

            // Move to next field if current field is filled
            if (field.value.length >= maxLength) {
                const nextField = field.nextElementSibling;
                if (nextField && nextField.classList.contains('otp-input')) {
                    nextField.focus();
                }
            }

            // Handle backspace to go to previous field
            if (event.key === 'Backspace' && field.value.length === 0) {
                const prevField = field.previousElementSibling;
                if (prevField && prevField.classList.contains('otp-input')) {
                    prevField.focus();
                }
            }

            // Only allow numbers
            field.value = field.value.replace(/[^0-9]/g, '');
        }

        // Handle OTP verification and login
        function handleOtpLogin() {
            // Get all OTP input values
            const otpInputs = document.querySelectorAll('.otp-input');
            let otpValue = '';

            otpInputs.forEach(input => {
                otpValue += input.value;
            });

            if (otpValue.length !== 6) {
                alert('Sila masukkan kod OTP 6 digit yang lengkap.');
                return;
            }

            // Get stored OTP and user ID
            const storedOtp = document.getElementById('otp_hidden').value;
            const userId = document.getElementById('user_id_hidden').value;

            // Show loading state
            const loginButton = document.querySelector('#fillOtp button');
            const originalButtonText = loginButton.innerHTML;
            loginButton.innerHTML = 'Mengesahkan...';
            loginButton.disabled = true;

            // Verify OTP
            if (otpValue === storedOtp) {
                // Redirect to reset password page using Laravel route
                window.location.href = "{{ route('resetPassword', ':id') }}".replace(':id', userId);
            } else {
                loginButton.innerHTML = originalButtonText;
                loginButton.disabled = false;
                alert('Kod OTP tidak sah. Sila cuba lagi.');
            }
        }
    </script>
</body>

</html>
