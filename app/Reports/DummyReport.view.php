<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\google\PieChart;
use \koolreport\widgets\google\LineChart;
use \koolreport\widgets\google\AreaChart;
?>

    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">Sales Report</h1>

        <!-- Bar Chart and Pie Chart in Same Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8">
            <!-- Bar Chart based on product_name -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Bar Chart - Sales by Product</h3>
                <?php
                BarChart::create([
                    "dataSource" => $this->dataStore("sales"),
                    "width" => "100%",
                    "height" => "400px",
                    "columns" => [
                        "product_name" => ["label" => "Product"],
                        "total_sales" => ["type" => "number", "label" => "Total Sales", "prefix" => "$"],
                    ],
                ]);
                ?>
            </div>

            <!-- Pie Chart based on product_name -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Pie Chart - Sales Distribution by Product</h3>
                <?php
                PieChart::create([
                    "dataSource" => $this->dataStore("sales"),
                    "columns" => [
                        "product_name" => ["label" => "Product"],
                        "total_sales" => ["type" => "number", "label" => "Total Sales", "prefix" => "$"],
                    ],
                ]);
                ?>
            </div>
        </div>

        <!-- Column Chart based on product_name -->
        <div class="mb-8 bg-white shadow rounded-lg p-6">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Column Chart - Sales by Product</h3>
            <?php
            ColumnChart::create([
                "dataSource" => $this->dataStore("sales"),
                "columns" => [
                    "product_name" => ["label" => "Product"],
                    "total_sales" => ["type" => "number", "label" => "Total Sales", "prefix" => "$"],
                ],
            ]);
            ?>
        </div>

        <!-- Line Chart based on sale_date -->
        <div class="mb-8 bg-white shadow rounded-lg p-6">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Line Chart - Sales Trend over Time</h3>
            <?php
            LineChart::create([
                "dataSource" => $this->dataStore("sales_day"),
                "width" => "100%",
                "height" => "400px",
                "columns" => [
                    "sale_date" => ["label" => "Date"],
                    "total_sales" => ["type" => "number", "label" => "Total Sales", "prefix" => "$"],
                ],
            ]);
            ?>
        </div>



        <!-- Table with Custom Styling -->
        <div class="mb-8 bg-white shadow rounded-lg p-6">
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

