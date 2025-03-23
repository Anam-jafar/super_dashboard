<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial</title>

    <link rel="icon" href="{{ asset('assets/icons/fin_logo_tiny.svg') }}" type="image/svg+xml">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-white">
    <div class="relative w-full max-w-6xl mx-auto px-4" x-data="{ activeIndex: 0, images: [] }" x-init="images = [
        '{{ asset('assets/icons/tutorial_1.jpeg') }}',
        '{{ asset('assets/icons/tutorial_2.jpeg') }}',
        '{{ asset('assets/icons/tutorial_3.jpeg') }}',
        '{{ asset('assets/icons/tutorial_4.jpeg') }}'
    ];">

        <!-- Image Slider -->
        <div class="relative mx-auto flex justify-center">
            <template x-for="(image, index) in images" :key="index">
                <img :src="image" alt="Tutorial"
                    class="w-full h-auto max-h-screen object-contain transition-all duration-500"
                    x-show="index === activeIndex">
            </template>

            <!-- Overlay Buttons for Large Screens -->
            <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 hidden md:flex gap-4">
                <button @click="activeIndex = (activeIndex - 1 + images.length) % images.length"
                    class="bg-white text-gray-800 px-6 py-3 rounded-full shadow-lg hover:bg-gray-100 transition-colors duration-300">
                    &#8592; Prev
                </button>
                <button @click="activeIndex = (activeIndex + 1) % images.length"
                    class="bg-white text-gray-800 px-6 py-3 rounded-full shadow-lg hover:bg-gray-100 transition-colors duration-300">
                    Next &#8594;
                </button>
            </div>
        </div>

        <!-- Bottom Buttons for Small Screens -->
        <div class="flex md:hidden justify-center gap-4 mt-4">
            <button @click="activeIndex = (activeIndex - 1 + images.length) % images.length"
                class="bg-white text-gray-800 px-4 py-2 rounded-full shadow-lg hover:bg-gray-100 transition-colors duration-300 text-sm">
                &#8592; Prev
            </button>
            <button @click="activeIndex = (activeIndex + 1) % images.length"
                class="bg-white text-gray-800 px-4 py-2 rounded-full shadow-lg hover:bg-gray-100 transition-colors duration-300 text-sm">
                Next &#8594;
            </button>
        </div>

        <!-- Auto Slide Script -->
        <script>
            document.addEventListener('alpine:init', () => {
                setInterval(() => {
                    const alpine = document.querySelector('[x-data]').__x;
                    if (alpine && alpine.$data.images.length) {
                        alpine.$data.activeIndex = (alpine.$data.activeIndex + 1) % alpine.$data.images.length;
                    }
                }, 3000);
            });
        </script>
    </div>
</body>

</html>
