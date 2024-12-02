@extends('layouts.base')

@section('content')

<div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold text-center mb-8">Create New Dashboard</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display Errors -->
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Dashboard Form -->
    <form action="{{ route('dashboard.store') }}" method="POST">
        @csrf

        <!-- Dashboard Name -->
        <div class="mb-4">
            <label for="dashboard_name" class="block text-gray-700">Dashboard Name</label>
            <input type="text" id="dashboard_name" name="dashboard_name" class="w-full px-4 py-2 border rounded" required>
        </div>

        <!-- Elements -->
        <div id="elements" class="space-y-4">
            <div class="element">
                <h2 class="text-xl font-semibold">Element 1</h2>
                <div class="mb-4">
                    <label for="element_name_1" class="block text-gray-700">Element Name</label>
                    <input type="text" name="elements[0][element_name]" class="w-full px-4 py-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="chart_type_1" class="block text-gray-700">Chart Type</label>
                    <select name="elements[0][chart_type]" class="w-full px-4 py-2 border rounded" required>
                        <option value="pie">Pie</option>
                        <option value="bar">Bar</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="width_1" class="block text-gray-700">Width</label>
                    <select name="elements[0][width]" class="w-full px-4 py-2 border rounded" required>
                        <option value="half">Half</option>
                        <option value="full">Full</option>
                    </select>
                </div>

                <!-- Parameters (Key-Value Pairs) -->
                <div id="prms_1" class="space-y-4">
                    <h3 class="text-lg font-semibold">Parameters</h3>
                    <div class="key-value-pair flex space-x-4">
                        <div class="mb-4 flex-1">
                            <label for="prms_key_1_1" class="block text-gray-700">Key</label>
                            <input type="text" name="elements[0][prms][0][key]" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4 flex-1">
                            <label for="prms_value_1_1" class="block text-gray-700">Value</label>
                            <input type="number" name="elements[0][prms][0][value]" class="w-full px-4 py-2 border rounded" required>
                        </div>
                    </div>

                    <div class="key-value-pair flex space-x-4">
                        <div class="mb-4 flex-1">
                            <label for="prms_key_1_2" class="block text-gray-700">Key</label>
                            <input type="text" name="elements[0][prms][1][key]" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4 flex-1">
                            <label for="prms_value_1_2" class="block text-gray-700">Value</label>
                            <input type="number" name="elements[0][prms][1][value]" class="w-full px-4 py-2 border rounded" required>
                        </div>
                    </div>
                </div>

                <!-- Add Key-Value Pair Button -->
                <div class="mb-4">
                    <button type="button" id="addKeyValuePair" class="px-4 py-2 bg-blue-500 text-white rounded">Add Key-Value Pair</button>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button type="button" id="addElement" class="px-4 py-2 bg-blue-500 text-white rounded">Add Element</button>
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Create Dashboard</button>
        </div>
    </form>
</div>

<!-- Script to dynamically add key-value pairs and elements -->
<script>
    let elementCount = 1;

    // Add Key-Value Pair
    document.getElementById('addKeyValuePair').addEventListener('click', function() {
        let pairCount = document.querySelectorAll('#prms_1 .key-value-pair').length;
        pairCount++;
        let newKeyValuePair = `
            <div class="key-value-pair flex space-x-4 mb-4">
                <div class="flex-1">
                    <label for="prms_key_1_${pairCount}" class="block text-gray-700">Key</label>
                    <input type="text" name="elements[0][prms][${pairCount - 1}][key]" class="w-full px-4 py-2 border rounded" required>
                </div>
                <div class="flex-1">
                    <label for="prms_value_1_${pairCount}" class="block text-gray-700">Value</label>
                    <input type="number" name="elements[0][prms][${pairCount - 1}][value]" class="w-full px-4 py-2 border rounded" required>
                </div>
            </div>
        `;
        document.getElementById('prms_1').insertAdjacentHTML('beforeend', newKeyValuePair);
    });

    // Add New Element
    document.getElementById('addElement').addEventListener('click', function() {
        elementCount++;
        let newElement = `
            <div class="element mb-4">
                <h2 class="text-xl font-semibold">Element ${elementCount}</h2>
                <div class="mb-4">
                    <label for="element_name_${elementCount}" class="block text-gray-700">Element Name</label>
                    <input type="text" name="elements[${elementCount - 1}][element_name]" class="w-full px-4 py-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="chart_type_${elementCount}" class="block text-gray-700">Chart Type</label>
                    <select name="elements[${elementCount - 1}][chart_type]" class="w-full px-4 py-2 border rounded" required>
                        <option value="pie">Pie</option>
                        <option value="bar">Bar</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="width_${elementCount}" class="block text-gray-700">Width</label>
                    <select name="elements[${elementCount - 1}][width]" class="w-full px-4 py-2 border rounded" required>
                        <option value="half">Half</option>
                        <option value="full">Full</option>
                    </select>
                </div>

                <!-- Parameters (Key-Value Pairs) -->
                <div id="prms_${elementCount}" class="space-y-4">
                    <h3 class="text-lg font-semibold">Parameters</h3>
                    <div class="key-value-pair flex space-x-4">
                        <div class="mb-4 flex-1">
                            <label for="prms_key_${elementCount}_1" class="block text-gray-700">Key</label>
                            <input type="text" name="elements[${elementCount - 1}][prms][0][key]" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4 flex-1">
                            <label for="prms_value_${elementCount}_1" class="block text-gray-700">Value</label>
                            <input type="number" name="elements[${elementCount - 1}][prms][0][value]" class="w-full px-4 py-2 border rounded" required>
                        </div>
                    </div>

                    <div class="key-value-pair flex space-x-4">
                        <div class="mb-4 flex-1">
                            <label for="prms_key_${elementCount}_2" class="block text-gray-700">Key</label>
                            <input type="text" name="elements[${elementCount - 1}][prms][1][key]" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4 flex-1">
                            <label for="prms_value_${elementCount}_2" class="block text-gray-700">Value</label>
                            <input type="number" name="elements[${elementCount - 1}][prms][1][value]" class="w-full px-4 py-2 border rounded" required>
                        </div>
                    </div>
                </div>

                <!-- Add Key-Value Pair Button -->
                <div class="mb-4">
                    <button type="button" id="addKeyValuePair_${elementCount}" class="px-4 py-2 bg-blue-500 text-white rounded">Add Key-Value Pair</button>
                </div>
            </div>
        `;
        document.getElementById('elements').insertAdjacentHTML('beforeend', newElement);
        
        // Reattach event listener to new button
        document.getElementById(`addKeyValuePair_${elementCount}`).addEventListener('click', function() {
            let pairCount = document.querySelectorAll(`#prms_${elementCount} .key-value-pair`).length;
            pairCount++;
            let newKeyValuePair = `
                <div class="key-value-pair flex space-x-4 mb-4">
                    <div class="flex-1">
                        <label for="prms_key_${elementCount}_${pairCount}" class="block text-gray-700">Key</label>
                        <input type="text" name="elements[${elementCount - 1}][prms][${pairCount - 1}][key]" class="w-full px-4 py-2 border rounded" required>
                    </div>
                    <div class="flex-1">
                        <label for="prms_value_${elementCount}_${pairCount}" class="block text-gray-700">Value</label>
                        <input type="number" name="elements[${elementCount - 1}][prms][${pairCount - 1}][value]" class="w-full px-4 py-2 border rounded" required>
                    </div>
                </div>
            `;
            document.getElementById(`prms_${elementCount}`).insertAdjacentHTML('beforeend', newKeyValuePair);
        });
    });
</script>

@endsection
