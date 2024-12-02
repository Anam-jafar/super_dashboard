<?php
use \koolreport\widgets\koolphp\Table;
?>

<div class="max-w-full mx-auto p-4 sm:p-6 space-y-8">
    <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">User Report</h1>

    <!-- Table to Display User Data -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 overflow-x-auto">
        <h3 class="text-2xl font-semibold text-gray-700 mb-4">User Data</h3>
        <?php
        Table::create([
            "dataSource" => $this->dataStore("user_data"),  // Use the data store where you saved user data
            "cssClass" => [
                "table" => "min-w-full table-auto border-collapse border border-gray-300",
                "th" => "px-4 py-2 text-left bg-gray-200 font-semibold",
                "td" => "px-4 py-2 border-t border-gray-300",
            ],
        ]);
        ?>
    </div>
</div>
