<?php

namespace Api\Accounts;

/**
 * Retrieves a list of unique account names from the transactions CSV data.
 *
 * @return string JSON-encoded array of unique account names.
 */
function getList()
{
    // Read transactions from CSV
    $transactions = \Data\DataIO\readCSV();

    // Extract unique account names
    $accounts = array_unique(array_column($transactions, "account"));

    // Sort the account names alphabetically
    sort($accounts);

    // Return the result as a JSON-encoded string
    return json_encode($accounts);
}
