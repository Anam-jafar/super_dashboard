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
        <div class="flex justify-center">
            <img src="{{ asset('assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-24 h-24" />
        </div>
        <!-- Title -->
        <h1 class="text-center text-2xl font-semibold text-blue-600 mb-8">TUKAR KATA LALUAN</h1>
        <!-- User Information Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 max-w-3xl mx-auto px-6 py-4 bg-white rounded-lg shadow">
            <!-- Name -->
            <div class="flex items-center">
                <span class="text-gray-900 font-semibold w-24">Name:</span>
                <span class="text-gray-600">{{ $user->name }}</span>
            </div>

            <!-- Position -->
            <div class="flex items-center">
                <span class="text-gray-900 font-semibold w-24">Jawatan:</span>
                <span class="text-gray-600">{{ $user->UserGroup->prm }}</span>
            </div>

            <!-- Mobile Number -->
            <div class="flex items-center">
                <span class="text-gray-900 font-semibold w-24">No H/P:</span>
                <span class="text-gray-600">{{ $user->hp }}</span>
            </div>

            <!-- Email -->
            <div class="flex items-center">
                <span class="text-gray-900 font-semibold w-24">Emel:</span>
                <span class="text-gray-600">{{ $user->mel }}</span>
            </div>
        </div>



        <!-- Form -->
        <form class="max-w-3xl mx-auto space-y-6" action="{{ route('resetPassword', ['id' => $user->id]) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <!-- New Password -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                    <label class="text-gray-900 font-medium w-full sm:w-48">Katalaluan Baru:</label>
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

                <!-- Confirm Password -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                    <label class="text-gray-900 font-medium w-full sm:w-48">Masuk Kembali Katalaluan:</label>
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
    </script>
@endpush
