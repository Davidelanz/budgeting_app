<?php

namespace Api\Categories;

/**
 * Generates a hierarchical tree structure of unique subcategories grouped by category from the transactions CSV data.
 *
 * @return string JSON-encoded array representing the tree structure.
 */
function getTree()
{
    // Read transactions from CSV
    $transactions = \Data\DataIO\readCSV();

    // Extract unique category names
    $categories = array_unique(array_column($transactions, 'category'));

    // Initialize an empty array to store subcategories grouped by category
    $subcategoriesByCategory = [];

    // Initialize subarrays for each category
    foreach ($categories as $category) {
        $subcategoriesByCategory[$category] = [];
    }

    // Populate the subcategoriesByCategory array
    foreach ($transactions as $transaction) {
        $category = $transaction['category'];
        $subcategory = $transaction['subcategory'];

        // Add subcategory to the corresponding category if not already present
        if (!in_array($subcategory, $subcategoriesByCategory[$category], true)) {
            $subcategoriesByCategory[$category][] = $subcategory;
        }
    }

    // Sort main keys (categories) alphabetically
    ksort($subcategoriesByCategory);

    // Sort subkeys (subcategories) alphabetically within each subarray
    foreach ($subcategoriesByCategory as &$subarray) {
        sort($subarray);
    }

    // Return the result as a JSON-encoded string representing the tree structure
    return json_encode($subcategoriesByCategory);
}
