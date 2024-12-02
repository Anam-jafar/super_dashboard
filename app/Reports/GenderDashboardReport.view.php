<?php
use \koolreport\widgets\google\PieChart;
use \koolreport\widgets\google\BarChart; // Assuming you might have BarChart or other chart types
?>

<div class="max-w-full mx-auto p-4 sm:p-6 space-y-8">
    <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">Dashboard Report</h1>

    <?php
    // Fetch the data from the data store
    $userData = $this->dataStore('user_data')->data();
    
    // Extract 'elements' data from the first entry
    $elements = !empty($userData) ? $userData[0]['elements'] : [];

    // Loop through elements to display charts dynamically
    foreach ($elements as $element) {
        // Check if chart type is provided and the required data is available
        if (!empty($element['chart_type']) && !empty($element['prms'])) {
            // Extract chart data
            $prms = $element['prms'];
            $chartType = $element['chart_type'];
            $width = isset($element['width']) && $element['width'] === 'full' ? '100%' : '50%';

            // Prepare chart data dynamically by mapping prms into category-value pairs
            $chartData = [['Category', 'Value']];
            foreach ($prms as $category => $value) {
                $chartData[] = [$category, $value];
            }

            // Get the element name to use as the title
            $elementName = isset($element['element_name']) ? $element['element_name'] : "Unknown Element";

            // Display chart based on chart type
            if ($chartType === 'pie') {
                // Pie Chart
                echo "<div class='bg-white shadow rounded-lg p-4 sm:p-6' style='width: $width;'>";
                echo "<h3 class='text-2xl font-semibold text-gray-700 mb-4'>" . htmlspecialchars($elementName) . "</h3>";
                PieChart::create([
                    "dataSource" => $chartData,
                    "width" => "100%",
                    "height" => "500px",
                    "options" => [
                        "title" => $elementName,
                        "legend" => ["position" => "top"],
                        "chartArea" => ["width" => "80%", "height" => "80%"],
                    ],
                ]);
                echo "</div>";
            } elseif ($chartType === 'bar') {
                // Bar Chart
                echo "<div class='bg-white shadow rounded-lg p-4 sm:p-6' style='width: $width;'>";
                echo "<h3 class='text-2xl font-semibold text-gray-700 mb-4'>" . htmlspecialchars($elementName) . "</h3>";
                BarChart::create([
                    "dataSource" => $chartData,
                    "width" => "100%",
                    "height" => "500px",
                    "options" => [
                        "title" => $elementName,
                        "legend" => ["position" => "top"],
                        "chartArea" => ["width" => "80%", "height" => "80%"],
                    ],
                ]);
                echo "</div>";
            }
            // You can add more conditional blocks for different chart types here
        }
    }
    ?>
</div>
