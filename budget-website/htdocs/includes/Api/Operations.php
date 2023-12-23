<?php

namespace Api\Operations;

/**
 * Retrieves a list of unique operation types from transaction data.
 *
 * This function reads transaction data, extracts the unique operation types,
 * sorts them alphabetically, and returns the list in JSON format.
 *
 * @return string JSON-encoded array containing unique operation types.
 */
function getList()
{
    // Fetch transaction data from CSV
    $transactions = \Data\DataIO\readCSV();

    // Extract unique operation types
    $operations = array_unique(array_column($transactions, "operation"));

    // Sort operation types alphabetically
    sort($operations);

    // Return the list in JSON format
    return json_encode($operations);
}
