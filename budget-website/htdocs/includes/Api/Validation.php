<?php

namespace Api\Validation;

/**
 * Retrieves warnings related to transfer transactions in JSON format with an array of objects.
 *
 * This endpoint module reads transaction data from a CSV file, identifies transfer transactions,
 * and checks for possible issues such as missing corresponding transfers on the same day with
 * the same positive amount. The result is a JSON-encoded array containing details of possible
 * wrong entries in the format of objects.
 *
 * @return string - JSON-encoded array of transfer-related warnings in object format.
 *
 * @throws \Exception - Throws an exception if there is an issue reading the CSV file or processing the data.
 *
 * @example
 * // Example usage in an API endpoint or controller:
 * $transferWarnings = \Api\Validation\getTransferWarningsArrayofObjects();
 * echo $transferWarnings;
 */
function getTransferWarningsArrayofObjects()
{
    try {
        // Fetch transaction data from CSV
        $transactions = \Data\DataIO\readCSV();
        // Validate transfer transactions
        $transferWarnings = \Data\Validator\validateTransfers($transactions);
        // Return warnings
        return json_encode($transferWarnings);
    } catch (\Exception $e) {
        // Handle exceptions
        throw new \Exception("Error fetching transfer warnings: " . $e->getMessage());
    }
}

/**
 * Retrieves warnings related to transfer transactions in JSON format with an array of arrays.
 *
 * This function fetches transfer warnings in the format of objects and converts them into
 * an array of arrays with a specific structure, including a header row. This format is suitable
 * for easier consumption or display.
 *
 * @return string - JSON-encoded array of transfer-related warnings in array format.
 */
function getTransferWarningsArrayofArrays()
{
    $transactions = json_decode(getTransferWarningsArrayofObjects(), true);
    $transactions = \Api\Transactions\convertToArraysFormat($transactions);
    return json_encode($transactions);
}
