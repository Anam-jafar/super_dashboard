<div>
    @if (session('success'))
        <div class="alert alert-success rounded-md p-4 mb-4">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-green-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7 13h.01M4 4l16 16" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger rounded-md p-4 mb-4">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-red-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7 13h.01M4 4l16 16" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning rounded-md p-4 mb-4">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-yellow-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7 13h.01M4 4l16 16" />
                </svg>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif
</div>
