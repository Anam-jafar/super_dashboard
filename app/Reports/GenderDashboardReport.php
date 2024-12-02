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
                    "connectionString" => "mongodb+srv://development:XT7GquBxdsk5wMru@ebossdevelopment.ekek02t.mongodb.net/?retryWrites=true&w=majority",  // MongoDB connection string
                    "database" => "super_dashboard",  // MongoDB database name
                ],
            ],
        ];
    }

    /**
     * Setup the report query and handle the data processing.
     */

    public function setup()
    {
        // Fetch Gender Dashboard data from MongoDB
        $this->src("reports")
            ->query([
                'collection' => 'dashboards',
                'find' => ['dashboard_name' => 'Superdashboard'],
                'options' => [
                    'projection' => ['elements' => 1],
                ],
            ])
            ->pipe($this->dataStore("user_data"));
    }

}
