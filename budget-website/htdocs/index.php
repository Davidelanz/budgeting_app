<?php
require_once dirname(__FILE__) . "/includes/_RequireAll.php";

$method = $_SERVER["REQUEST_METHOD"];
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Define routes
$routes = [
    "GET" => [
        "/" => "homePage",
        "/api/download.csv" => "Api\Download\CSV",
        "/api/transactions.json" => "Api\Transactions\getArrayofArrays",
        "/api/operations.json" => "getOperations",
        "/api/accounts.json" => "getAccounts",
        "/api/categories.json" => "getCategories",
        "/api/categories/subcategories.json" => "getSubcategoriesByCategory",
        "/api/subcategories.json" => "getSubcategories",
    ],
    "POST" => [
        "/api/upload.csv" => "uploadCSV",
    ],
];

// Execute the corresponding function based on the route
if (isset($routes[$method][$path])) {
    $function = $routes[$method][$path];
    if ($function === "homePage") {
        include "home.php";
    } else {
        echo $function();
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Endpoint not found"]);
}
