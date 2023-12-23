<?php

namespace Api;

/**
 * Retrieves all available API routes including main and prototype routes.
 *
 * This function merges the main and prototype routes for both GET and POST methods.
 *
 * @return array An associative array containing GET and POST routes.
 */
function AllRoutes()
{
    return [
        "GET" => array_merge(Routes()["GET"] ?? [], PrototypeRoutes()["GET"] ?? []),
        "POST" => array_merge(Routes()["POST"] ?? [], PrototypeRoutes()["POST"] ?? []),
    ];
}


function Routes()
{
    return [
        "GET" => [
            "/" => [
                "handler" => "homePage",
                "description" => "Homepage",
            ],
            "/api/download.csv" => [
                "handler" => "Api\Download\CSV",
                "description" => "Download CSV data",
            ],
            "/api/transactions.json" => [
                "handler" => "Api\Transactions\getArrayofArrays",
                "description" => "Get transaction data based on date range"
            ],
            "/api/transactions/categories.json" => [
                "handler" => "Api\Transactions\getCategorySubtotals",
                "description" => "Get transaction subtotals grouped by category and subcategory on date range"
            ],
            "/api/categories.json" => [
                "handler" => "Api\Categories\getTree",
                "description" => "List all unique category names with all unique subcategories within"
            ],
            "/api/operations.json" => [
                "handler" => "Api\Operations\getList",
                "description" => "List all unique operation names"
            ],
            "/api/accounts.json" => [
                "handler" => "Api\Accounts\getList",
                "description" => "List all unique account names"
            ],
        ],
    ];
}


function PrototypeRoutes()
{
    return [
        "POST" => [
            "/api/upload.csv" => [
                "handler" => "uploadCSV",
                "description" => "upload CSV data",
            ],
        ],
    ];
}


/**
 * Generates HTML documentation for available API endpoints.
 *
 * This function outputs HTML documentation for both GET and POST API endpoints,
 * including their descriptions and prototype status.
 */
function generateApiDocumentation()
{
    $routes = AllRoutes();
    $prototypeRoutes = PrototypeRoutes();

    echo '<p>The following API endpoints are available:</p>';
    echo '<ul>';
    foreach ($routes["GET"] as $endpoint => $route) {
        echo '<li><a href="' . $endpoint . '"><code>GET ' . $endpoint . '</code></a> - ' . $route["description"] . '</li>';
    }
    echo '</ul>';

    echo '<p>The following API endpoints are being prototyped:</p>';
    echo '<ul>';
    foreach ($prototypeRoutes["POST"] as $endpoint => $route) {
        echo '<li><a href="' . $endpoint . '"><code>POST ' . $endpoint . '</code></a> - ' . $route["description"] . '</li>';
    }
    echo '</ul>';
}
