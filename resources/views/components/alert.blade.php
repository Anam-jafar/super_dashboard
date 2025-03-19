<div>
    @if (session('success'))
        <div class="alert alert-success"
            style="background-color: #16A34A; color: white; border-radius: 8px; padding: 16px; margin-bottom: 16px; animation: fadeOut 4s ease-in-out;">
            <div style="display: flex; align-items: center;">
                <svg style="height: 24px; width: 24px; margin-right: 8px;" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger"
            style="background-color: #DC2626; color: white; border-radius: 8px; padding: 16px; margin-bottom: 16px; animation: fadeOut 4s ease-in-out;">
            <div style="display: flex; align-items: center;">
                <svg style="height: 24px; width: 24px; margin-right: 8px;" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                        fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9l-6 6m0-6l6 6" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning"
            style="background-color: #F97316; color: white; border-radius: 8px; padding: 16px; margin-bottom: 16px; animation: fadeOut 4s ease-in-out;">
            <div style="display: flex; align-items: center;">
                <svg style="height: 24px; width: 24px; margin-right: 8px;" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                        fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
                </svg>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif

    <!-- Display Validation Errors Only if No Session Error Exists -->
    @if ($errors->any() && !session('error'))
        <div class="alert alert-danger"
            style="background-color: #DC2626; color: white; border-radius: 8px; padding: 16px; margin-bottom: 16px; animation: fadeOut 4s ease-in-out;">
            <div style="display: flex; align-items: center;">
                <svg style="height: 24px; width: 24px; margin-right: 8px;" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                        fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9l-6 6m0-6l6 6" />
                </svg>
                <div>
                    @foreach ($errors->all() as $error)
                        <p style="margin: 0;">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <style>
        .animate-fade-out {
            animation: fadeOut 4s ease-in-out;
            opacity: 1;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>

    <script>
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease-out";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500); // Remove after fade-out
                }
            }, 4000);
        });
    </script>
</div>
