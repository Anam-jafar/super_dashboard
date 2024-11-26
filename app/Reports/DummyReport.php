<?php

namespace App\Reports;

use koolreport\KoolReport;
use koolreport\laravel\Friendship;

class DummyReport extends KoolReport
{
    use Friendship;

    public function setup()
    {
        // Query for sales by product
        $queryProduct = "SELECT product_name, SUM(quantity * price) AS total_sales
                         FROM sales";
    
        $startDate = $this->params["startDate"] ?? null;
        $endDate = $this->params["endDate"] ?? null;
    
        if (!empty($startDate) && !empty($endDate)) {
            $queryProduct .= " WHERE sale_date BETWEEN :startDate AND :endDate";
        }
    
        $queryProduct .= " GROUP BY product_name";

        // Query for sales by date, with sorting by sale_date
        $queryDay = "SELECT sale_date, SUM(quantity * price) AS total_sales
                     FROM sales";
    
        if (!empty($startDate) && !empty($endDate)) {
            $queryDay .= " WHERE sale_date BETWEEN :startDate AND :endDate";
        }
    
        $queryDay .= " GROUP BY sale_date ORDER BY sale_date ASC";  // Added ORDER BY clause

        // Fetch data for product sales
        $this->src("mysql")
            ->query($queryProduct)
            ->params([
                ":startDate" => $startDate,
                ":endDate" => $endDate,
            ])
            ->pipe($this->dataStore("sales"));

        // Fetch data for sales grouped by date
        $this->src("mysql")
            ->query($queryDay)
            ->params([
                ":startDate" => $startDate,
                ":endDate" => $endDate,
            ])
            ->pipe($this->dataStore("sales_day"));
    }
}
    