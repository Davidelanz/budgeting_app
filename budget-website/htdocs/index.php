<?php

/**
 * Main entry point for the web application.
 *
 * This script handles incoming HTTP requests, parses the route, and executes the corresponding API function.
 * It serves as the main controller for the web application, routing requests to the appropriate API functions.
 *
 */

// Include required files and classes
require_once dirname(__FILE__) . "/includes/_RequireAll.php";

// Get the HTTP method and path from the server environment
$method = $_SERVER["REQUEST_METHOD"];
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Retrieve available routes
$routes = Api\AllRoutes();

// Execute the corresponding function based on the route
if (isset($routes[$method][$path])) {
    // Get the route information
    $route = $routes[$method][$path];
    $handler = $route["handler"];

    // Check for the home page route
    if ($handler === "homePage") {
        // Include the home page file
        include "home.php";
    } else {
        // Execute the API function and output the result
        echo $handler();
    }
} else {
    // Handle 404 - Endpoint not found
    http_response_code(404);
    echo json_encode(["error" => "Endpoint not found"]);
}
