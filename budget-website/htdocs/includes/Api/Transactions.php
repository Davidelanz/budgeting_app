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

    sort($filteredTransactions);
    return json_encode($filteredTransactions);
}


/**
 * Converts an array of transactions to a specific structure.
 *
 * This function takes an array of transactions and transforms them into
 * an array of arrays with a specific structure, including a header row.
 *
 * @param array $transactions - An array of transactions.
 * @return array - An array of arrays with a specific structure.
 */
function convertToArraysFormat($transactions)
{
    $result = [];

    // Add header row
    $result[] = ["date", "operation", "amount", "account", "category", "subcategory", "note"];

    // Add data rows
    foreach ($transactions as $transaction) {
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

    return $result;
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
    $transactions = json_decode(getArrayofObjects(), true);
    $transactions = convertToArraysFormat($transactions);
    return json_encode($transactions);
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

/**
 * Calculates and retrieves the cumulative total amount day-by-day.
 *
 * @return string JSON-encoded array of cumulative total amounts day-by-day.
 */
function getDailyCumulative()
{
    $filteredTransactions = json_decode(getArrayofObjects(), true);

    $cumulativeTotal = 0;
    $cumulativeTotalByDay = [];

    foreach ($filteredTransactions as $transaction) {
        $date = $transaction["date"];
        $amount = (float)$transaction["amount"];

        if (!isset($cumulativeTotalByDay[$date])) {
            $cumulativeTotalByDay[$date] = 0;
        }

        $cumulativeTotal += $amount;
        $cumulativeTotalByDay[$date] = $cumulativeTotal;
    }

    return json_encode($cumulativeTotalByDay);
}

/**
 * Calculates and retrieves the cumulative total amount day-by-day for each account.
 *
 * This function processes a list of transactions, calculates the cumulative total
 * amount for each account on a daily basis, and returns the results in JSON format.
 *
 * @return string JSON-encoded array of cumulative total amounts day-by-day for each account.
 * @function
 * @name getDailyCumulativeByAccount
 * @memberof Transactions
 * @example
 * // Example JSON output:
 * // {
 * //   "Account1": {
 * //     "2021-11-01": 100,
 * //     "2021-11-12": 190,
 * //     "2021-12-01": 300,
 * //     // ... more dates
 * //   },
 * //   "Account2": {
 * //     "2021-11-01": 50,
 * //     "2021-11-12": 80,
 * //     "2021-12-01": 120,
 * //     // ... more dates
 * //   },
 * //   // ... more accounts
 * // }
 */
function getDailyCumulativeByAccount()
{
    // Retrieve filtered transactions from the CSV file
    $filteredTransactions = json_decode(getArrayofObjects(), true);

    // Initialize an array to store cumulative totals for each account and date
    $cumulativeTotalByAccount = [];

    // Initialize a buffer to store the last date with an amount for each account
    $lastDateBuffer = [];

    // Process each transaction to calculate cumulative totals
    foreach ($filteredTransactions as $transaction) {
        $date = $transaction["date"];
        $amount = (float)$transaction["amount"];
        $account = $transaction["account"];

        if (!isset($cumulativeTotalByAccount[$account])) {
            $cumulativeTotalByAccount[$account] = [];
            $cumulativeTotalByAccount[$account][$date] = $amount;
            $lastDate = $date;
        } else {
            // Get the last date with an amount for the current account from the buffer
            $lastDate = $lastDateBuffer[$account];
            $cumulativeFromPreviousDate = $cumulativeTotalByAccount[$account][$lastDate];
            // Calculate the cumulative total for the current date and account
            $cumulativeTotalByAccount[$account][$date] = $cumulativeFromPreviousDate + $amount;
        }

        // Update the last date buffer for the current account
        $lastDateBuffer[$account] = $date;
    }

    return json_encode($cumulativeTotalByAccount);
}

