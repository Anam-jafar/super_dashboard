<div>
    @if (session('success'))
        <div class="alert alert-success"
            style="background-color: #16A34A; color: white; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
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
            style="background-color: #DC2626; color: white; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
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
            style="background-color: #F97316; color: white; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
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
            style="background-color: #DC2626; color: white; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
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
        @keyframes fadeOut {

            0%,
            70% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>

    <script>
        document.querySelectorAll('.alert').forEach(alert => {
            // Set animation after a short delay to ensure it's applied
            setTimeout(() => {
                alert.style.animation = "fadeOut 4s ease-in-out 7s forwards";
            }, 100);

            // Remove the alert completely after the full animation
            setTimeout(() => {
                alert.remove();
            }, 11000); // 7s visibility + 4s fade out
        });
    </script>
</div>
