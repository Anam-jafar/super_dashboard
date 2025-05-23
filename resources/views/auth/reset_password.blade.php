@extends('layouts.loginLayout')

@push('styles')
    <style>
        .password-input-wrapper {
            position: relative;
        }

        .eye-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
    </style>
@endpush

@section('content')
    <div class="space-y-16 p-6 max-w-screen-lg mx-auto">
        <!-- Logo -->

        <div class="flex justify-center mb-8">
            <img src="{{ asset('assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="h-[7.5rem] w-auto" />
        </div>

        <!-- Title -->
        <h1 class="text-center text-3xl font-semibold text-blue-600 mb-8">TUKAR KATA LALUAN</h1>
        <!-- User Information Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 max-w-3xl mx-auto px-6 py-4 bg-white rounded-lg shadow">
            <!-- Name -->
            <div class="flex items-center">
                <span class="text-gray-900 font-semibold w-24">Nama</span>
                <span class="text-gray-600">{{ $user->name }}</span>
            </div>

            <!-- Position -->
            <div class="flex items-center">
                <span class="text-gray-900 font-semibold w-24">Jawatan</span>
                <span class="text-gray-600">{{ $user->UserGroup->prm }}</span>
            </div>

            <!-- Mobile Number -->
            <div class="flex items-center">
                <span class="text-gray-900 font-semibold w-24">No Telefon</span>
                <span class="text-gray-600">{{ $user->hp }}</span>
            </div>

            <!-- Email -->
            <div class="flex items-center">
                <span class="text-gray-900 font-semibold w-24">Emel</span>
                <span class="text-gray-600">{{ $user->mel }}</span>
            </div>
        </div>



        <!-- Form -->
        <form class="max-w-3xl mx-auto space-y-6" action="{{ route('resetPassword', ['id' => $user->id]) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <!-- New Password -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                    <label class="text-gray-900 font-medium w-full sm:w-48">Katalaluan Baru</label>
                    <div class="password-input-wrapper w-full">
                        <input type="password" class="w-full p-3 border border-gray-300 rounded-lg pr-10" name="password"
                            placeholder="********" />
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="eye-icon h-5 w-5 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>

                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Confirm Password -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                    <label class="text-gray-900 font-medium w-full sm:w-48">Masuk Kembali Katalaluan</label>
                    <div class="password-input-wrapper w-full">
                        <input type="password" class="w-full p-3 border border-gray-300 rounded-lg pr-10"
                            name="confirm_password" placeholder="********" />
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="eye-icon h-5 w-5 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
                @error('confirm_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white p-4 rounded-lg text-gray-900">
                <p class="font-semibold mb-2">Syarat Katalaluan:</p>
                <ul class="list-decimal list-inside text-sm text-gray-700 space-y-1">
                    <li class="req-length text-red-500">Sekurang-kurangnya 8 karakter (a-z)</li>
                    <li class="req-uppercase text-red-500">Sekurang-kurangnya 1 Huruf Besar (A-Z)</li>
                    <li class="req-lowercase text-red-500">Sekurang-kurangnya 1 Huruf Kecil (a-z)</li>
                    <li class="req-number text-red-500">Sekurang-kurangnya 1 Nombor (0-9)</li>
                    <li class="req-symbol text-red-500">Sekurang-kurangnya 1 Simbol (@!$~#)</li>
                </ul>
            </div>

            <!-- Buttons -->
            <div class="flex justify-center gap-4 pt-4">
                <button type="button"
                    class="px-12 py-2.5 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition-colors min-w-[160px]"
                    onclick="document.querySelector('[name=password]').value = ''; document.querySelector('[name=confirm_password]').value = '';">
                    Set Semula
                </button>
                <button type="submit"
                    class="px-12 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors min-w-[160px]">
                    Simpan
                </button>
            </div>
            <div class="text-center !mt-4 !mb-4">
                <a href="{{ route('login') }}" class="text-base text-blue-600 hover:underline">Kembali ke Paparan Log
                    Masuk</a>
            </div>

        </form>
    </div>

    <!-- Copyright -->
    <div class="flex justify-center items-center gap-2 text-sm text-gray-900">
        <img src="{{ asset('assets/icons/fin_logo_tiny.svg') }}" alt="Admin" class="w-18 h-18" />
        <p>Hakcipta terpelihara oleh Majlis Agama Islam Selangor (MAIS)</p>
    </div>
@endsection






@push('scripts')
    <script>
        // Add this script to toggle password visibility
        document.querySelectorAll('.eye-icon').forEach(icon => {
            icon.addEventListener('click', () => {
                const input = icon.parentElement.querySelector('input');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    `;
                } else {
                    input.type = 'password';
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const confirmPasswordInput = document.querySelector('input[name="confirm_password"]');
            const requirements = [{
                    regex: /.{8,}/,
                    element: document.querySelector('.req-length')
                }, // Minimum 8 characters
                {
                    regex: /[A-Z]/,
                    element: document.querySelector('.req-uppercase')
                }, // At least one uppercase letter
                {
                    regex: /[a-z]/,
                    element: document.querySelector('.req-lowercase')
                }, // At least one lowercase letter
                {
                    regex: /[0-9]/,
                    element: document.querySelector('.req-number')
                }, // At least one number
                {
                    regex: /[@!$~#]/,
                    element: document.querySelector('.req-symbol')
                } // At least one special character
            ];

            function validatePassword() {
                const password = passwordInput.value;

                requirements.forEach(req => {
                    if (req.regex.test(password)) {
                        req.element.classList.remove('text-red-500');
                        req.element.classList.add('text-green-500');
                    } else {
                        req.element.classList.remove('text-green-500');
                        req.element.classList.add('text-red-500');
                    }
                });

                validateConfirmPassword(); // Also check confirm password when typing new password
            }

            function validateConfirmPassword() {
                if (confirmPasswordInput.value === passwordInput.value && passwordInput.value.length > 0) {
                    confirmPasswordInput.classList.add('border-green-500');
                    confirmPasswordInput.classList.remove('border-red-500');
                } else {
                    confirmPasswordInput.classList.add('border-red-500');
                    confirmPasswordInput.classList.remove('border-green-500');
                }
            }

            passwordInput.addEventListener('input', validatePassword);
            confirmPasswordInput.addEventListener('input', validateConfirmPassword);
        });
    </script>
@endpush
