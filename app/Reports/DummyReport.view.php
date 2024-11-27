<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\PieChart;
use \koolreport\widgets\google\LineChart;
use \koolreport\widgets\google\AreaChart;
?>

<div class="max-w-full mx-auto p-4 sm:p-6 space-y-8">
    <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">Sales Report</h1>

    <!-- Bar Chart and Pie Chart in Same Row -->
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1 bg-white shadow rounded-lg p-4 sm:p-6">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Bar Chart - Sales by Product</h3>
            <?php
            BarChart::create([
                "dataSource" => $this->dataStore("sales"),
                "width" => "100%",
                "height" => "500px",
                "columns" => [
                    "product_name" => ["label" => "Product"],
                    "total_sales" => ["type" => "number", "label" => "Total Sales", "prefix" => "$"],
                ],
                "options" => [
                    "legend" => ["position" => "top"],
                    "chartArea" => ["width" => "80%", "height" => "80%"],
                ],
            ]);
            ?>
        </div>

        <div class="flex-1 bg-white shadow rounded-lg p-4 sm:p-6">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Pie Chart - Sales Distribution by Product</h3>
            <?php
            PieChart::create([
                "dataSource" => $this->dataStore("sales"),
                "width" => "100%",
                "height" => "500px",
                "columns" => [
                    "product_name" => ["label" => "Product"],
                    "total_sales" => ["type" => "number", "label" => "Total Sales", "prefix" => "$"],
                ],
                "options" => [
                    "legend" => ["position" => "right"],
                    "chartArea" => ["width" => "80%", "height" => "80%"],
                ],
            ]);
            ?>
        </div>
    </div>

    <!-- Column Chart -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6">
        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Column Chart - Sales by Product</h3>
        <?php
        ColumnChart::create([
            "dataSource" => $this->dataStore("sales"),
            "width" => "100%",
            "height" => "600px",
            "columns" => [
                "product_name" => ["label" => "Product"],
                "total_sales" => ["type" => "number", "label" => "Total Sales", "prefix" => "$"],
            ],
            "options" => [
                "legend" => ["position" => "top"],
                "chartArea" => ["width" => "85%", "height" => "80%"],
            ],
        ]);
        ?>
    </div>

    <!-- Line Chart -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6">
        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Line Chart - Sales Trend over Time</h3>
        <?php
        LineChart::create([
            "dataSource" => $this->dataStore("sales_day"),
            "width" => "100%",
            "height" => "600px",
            "columns" => [
                "sale_date" => ["label" => "Date"],
                "total_sales" => ["type" => "number", "label" => "Total Sales", "prefix" => "$"],
            ],
            "options" => [
                "legend" => ["position" => "top"],
                "chartArea" => ["width" => "85%", "height" => "80%"],
            ],
        ]);
        ?>
    </div>

    <!-- Table -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 overflow-x-auto">
        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Detailed Sales Data</h3>
        <?php
        Table::create([
            "dataSource" => $this->dataStore("sales"),
            "cssClass" => [
                "table" => "min-w-full table-auto border-collapse border border-gray-300",
                "th" => "px-4 py-2 text-left bg-gray-200 font-semibold",
                "td" => "px-4 py-2 border-t border-gray-300",
            ],
        ]);
        ?>
    </div>
</div>