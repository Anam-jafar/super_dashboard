@extends('layouts.app')

@section('styles')
<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translate3d(0, -20px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes fadeOutUp {
        from {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
        to {
            opacity: 0;
            transform: translate3d(0, -20px, 0);
        }
    }

    .animate-fade-in-down {
        animation: fadeInDown 0.3s ease-out;
    }

    .animate-fade-out-up {
        animation: fadeOutUp 0.3s ease-in;
    }
</style>

@endsection

@section('content')

<div class="main-content app-content">
<div class="container-fluid">
<div class="max-w-full mx-auto mt-4 p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-[80vh]">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-2 sm:space-y-0">
        <h1 class="text-xl font-bold text-gray-800">Kaffarah Settings</h1>
        <a href="{{ route('compensation.create') }}" class="bg-blue-600 text-white px-4 py-1 rounded-full hover:bg-blue-700 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-lg">
            Add New Kaffarah Settings
        </a>
    </div>

    @if (session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-r-lg animate-fade-in-down">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-r-lg animate-fade-in-down">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <h2 class="text-lg font-bold text-gray-700 mb-3">Current Active Setting</h2>
        @if ($activeSetting)
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="mb-1 text-sm"><span class="font-semibold text-blue-700">Code:</span> {{ $activeSetting['setting_code'] }}</p>
                <p class="text-sm"><span class="font-semibold text-blue-700">ID:</span> {{ $activeSetting['setting_id'] }}</p>
            </div>
        @else
            <p class="text-gray-600 italic text-sm">No active setting found.</p>
        @endif
    </div>

    <div class="space-y-4">
        @foreach ($payment_metrix as $index => $setting)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition duration-300 ease-in-out transform hover:shadow-xl">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 cursor-pointer" onclick="toggleCard('card-{{ $index }}')">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center mb-3 sm:mb-0">
                        <h3 class="text-lg font-semibold text-gray-800 mr-2">{{ $setting['title'] }}</h3>
                        <span class="mt-1 sm:mt-0 px-2 py-1 rounded-full text-xs font-medium {{ $setting['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $setting['is_active'] ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @if (!$setting['is_active'])
                        <form action="{{ route('compensation.markAsActive', (string) $setting['_id']) }}" method="POST" class="mt-3 sm:mt-0">
                            @csrf
                            @method('POST')
                            <button type="submit" class="px-4 py-1 text-sm text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                Mark as Active
                            </button>
                        </form>
                    @endif
                </div>

                <div id="card-{{ $index }}" class="hidden">
                    <div class="px-4 pb-4 space-y-4">
                        <div>
                            <h4 class="font-semibold text-sm text-gray-700 mb-2">Offense Types:</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Offense</th>
                                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Person to Feed</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($setting['offense_type'] as $offense)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $offense['parameter'] }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $offense['value'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-sm text-gray-700 mb-2">Kaffarah Items:</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kaffarah</th>
                                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($setting['kaffarah_item'] as $item)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item['name'] }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">RM. {{ $item['price'] }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">RM. {{ $item['rate_value'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-700"><span class="font-semibold">Rate:</span> {{ $setting['rate'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</div>
</div>
@endsection


@section('scripts')
<script>
    function toggleCard(id) {
        const element = document.getElementById(id);
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
            element.classList.add('animate-fade-in-down');
        } else {
            element.classList.add('animate-fade-out-up');
            setTimeout(() => {
                element.classList.remove('animate-fade-out-up');
                element.classList.add('hidden');
            }, 300);
        }
    }
</script>



@endsection
