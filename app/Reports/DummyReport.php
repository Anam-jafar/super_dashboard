<?php
namespace App\Reports;

use koolreport\KoolReport;
use koolreport\laravel\Friendship;

class DummyReport extends KoolReport
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
                "users" => [  
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
        // Querying the 'users' collection
        $this->src('users')  
            ->query([
                'collection' => 'users',  // Name of the collection
                'find' => [],  // Empty find to get all users
                'options' => [
                    'skip' => 0,  // No skipping
                    'limit' => 5,  // Limit to 5 records
                    'projection' => [
                        '_id' => 0,  // Exclude _id
                        'name' => 1, // Include 'name' field
                        'email' => 1, // Include 'email' field
                    ],    
                ],
            ])
            ->pipe($this->dataStore('user_data'));  // Store the result in 'user_data' data store
    }
}
