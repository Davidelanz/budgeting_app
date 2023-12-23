<?php

namespace Api\Transactions;

/**
 * Retrieves an array of transactions in JSON format.
 *
 * This function fetches all transactions from the CSV file and filters them based on the
 * provided start and end dates (if specified in the GET parameters). The filtered transactions
 * are returned as an array of objects in JSON format.
 *
 * @return string JSON-encoded array of transactions.
 */
function getArrayofObjects()
{
    $transactions = \Data\DataIO\readCSV();
    $startDate = isset($_GET["start_date"]) ? strtotime($_GET["start_date"]) : 0;
    $endDate = isset($_GET["end_date"]) ? strtotime($_GET["end_date"]) : time();

    $filteredTransactions = array_filter($transactions, function ($transaction) use ($startDate, $endDate) {
        $transactionDate = strtotime($transaction["date"]);
        return $transactionDate >= $startDate && $transactionDate <= $endDate;
    });

    return json_encode($filteredTransactions);
}

/**
 * Retrieves an array of transactions in JSON format with a specific structure.
 *
 * This function fetches all transactions from the CSV file and filters them based on the
 * provided start and end dates (if specified in the GET parameters). The filtered transactions
 * are returned as an array of arrays with a specific structure (including a header row) in JSON format.
 *
 * @return string JSON-encoded array of transactions with a specific structure.
 */
function getArrayofArrays()
{
    $transactions = \Data\DataIO\readCSV();
    $startDate = isset($_GET["start_date"]) ? strtotime($_GET["start_date"]) : 0;
    $endDate = isset($_GET["end_date"]) ? strtotime($_GET["end_date"]) : time();

    $filteredTransactions = array_filter($transactions, function ($transaction) use ($startDate, $endDate) {
        $transactionDate = strtotime($transaction["date"]);
        return $transactionDate >= $startDate && $transactionDate <= $endDate;
    });

    $result = [];

    // Add header row
    $result[] = ["date", "operation", "amount", "account", "category", "subcategory", "note"];

    // Add data rows
    foreach ($filteredTransactions as $transaction) {
        $result[] = [
            $transaction["date"],
            (float)$transaction["amount"], // Convert amount to float
            $transaction["operation"],
            $transaction["account"],
            $transaction["category"],
            $transaction["subcategory"],
            $transaction["note"],
        ];
    }

    return json_encode($result);
}


/**
 * Calculates and retrieves the subtotal for each category within the specified date range.
 *
 * @return string JSON-encoded array of category subtotals.
 */
function getCategorySubtotals()
{
    $filteredTransactions = json_decode(getArrayofObjects(), true);

    $categorySubtotals = [];

    foreach ($filteredTransactions as $transaction) {
        $category = $transaction["category"];
        $amount = (float)$transaction["amount"];

        if (!isset($categorySubtotals[$category])) {
            $categorySubtotals[$category] = 0;
        }

        $categorySubtotals[$category] += $amount;
    }

    // Convert the associative array to an indexed array
    $result = [];
    foreach ($categorySubtotals as $category => $subtotal) {
        $result[] = ["category" => $category, "subtotal" => $subtotal];
    }

    return json_encode($result);
}
