<?php

namespace App\Reports;

use koolreport\KoolReport;
use koolreport\laravel\Friendship;

class GenderDashboardReport extends KoolReport
{
    use Friendship;

    /**
     * Define the data source settings for MongoDB.
     *
     * @return array
     */
    public function settings()
    {
        return [
            "dataSources" => [
                "reports" => [
                    "class" => '\koolreport\mongodb\MongoDataSource',
                    "connectionString" => "mongodb+srv://development:XT7GquBxdsk5wMru@ebossdevelopment.ekek02t.mongodb.net/?retryWrites=true&w=majority", // MongoDB connection string
                    "database" => "super_dashboard", // MongoDB database name
                ],
            ],
        ];
    }

    /**
     * Setup the report query and handle the data processing.
     */
    public function setup()
    {
        // Get the dashboard name from the params passed to the report
        $dashboardName = $this->params['dashboardName'] ?? 'Admin Dashboard';  // Default to 'Admin Dashboard'

        // Fetch Gender Dashboard data from MongoDB with dynamic dashboard name
        $this->src("reports")
            ->query([
                'collection' => 'dashboards',
                'find' => ['dashboard_name' => $dashboardName],  // Use dynamic dashboard name
                'options' => [
                    'projection' => ['elements' => 1],
                ],
            ])
            ->pipe($this->dataStore("user_data"));
    }
}
