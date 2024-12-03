<?php

namespace App\Reports;

use koolreport\KoolReport;
use koolreport\laravel\Friendship;

class DashboardReport extends KoolReport
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
                    "database" => "super_dashboard",
                ],
            ],
        ];
    }

    /**
     * Setup the report query and handle the data processing.
     */
    public function setup()
    {
        // Static data for demonstration
        $dummyData = [
            ["customerName" => "Johny Deep", "dollar_sales" => 100],
            ["customerName" => "Angelina Jolie", "dollar_sales" => 200],
            ["customerName" => "Brad Pitt", "dollar_sales" => 200],
            ["customerName" => "Nicole Kidman", "dollar_sales" => 100],
        ];

        // Feed the static data into the data store
        $this->dataStore("user_data")->data($dummyData);

        // Dummy data for the pie chart
        $dummyData = [
            ["category" => "Electronics", "sales" => 500],
            ["category" => "Furniture", "sales" => 300],
            ["category" => "Clothing", "sales" => 200],
            ["category" => "Books", "sales" => 100],
        ];

        // Feed the static data into the data store
        $this->dataStore("sales_data")->data($dummyData);
    }
}
