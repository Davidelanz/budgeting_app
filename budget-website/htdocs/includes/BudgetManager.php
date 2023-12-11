<?php

namespace BudgetManager;

use DateTime;

define("TODAY", date('Y-m-d'));
define("MIN_DATE", "1900-01-01");

/**
 * Transfers an amount between two accounts
 *
 * @param array $transferDetails Transfer details
 * @param string|null $dataDir Data directory (optional)
 */
function transferAmount(array $transferDetails, ?string $dataDir = null)
{
    // Implementation for transferring amount
}

/**
 * Add a new entry to the data
 *
 * @param array $new_entry
 */
function addEntry(array $new_entry)
{
    // Implementation for Adding a new entry
}

/**
 * Selects only the operations done in a specific date range
 *
 * @param array $operationsArray Array with all operations
 * @param string $startDate Start date of the range
 * @param string $endDate End date of the range
 *
 * @return array
 */
function filterByDate(array $operationsArray, string $startDate, string $endDate)
{
    $filteredArray = [];

    foreach ($operationsArray as $row) {
        if ($row['date'] >= $startDate && $row['date'] < $endDate) {
            $filteredArray[] = $row;
        }
    }

    return $filteredArray;
}

/**
 * Filters operations by category
 *
 * @param array $operationsArray Array with all operations
 * @param string $category Category to filter
 *
 * @return array
 */
function filterByCategory(array $operationsArray, string $category)
{
    $filteredArray = [];

    foreach ($operationsArray as $row) {
        if ($row['category'] == $category) {
            $filteredArray[] = $row;
        }
    }

    return $filteredArray;
}

/**
 * Gets account balances up to a specific end date
 *
 * @param array $operationsArray Array with all operations
 * @param string $endDate End date for balance calculation
 *
 * @return array
 */
function getAccountBalances(array $operationsArray, string $endDate)
{
    $filteredArray = filterByDate($operationsArray, MIN_DATE, $endDate);
    $accounts = array_unique(array_column($operationsArray, "account"));
    $dataArray = [];

    foreach ($accounts as $account) {
        $dataArray[$account] = 0;
    }

    foreach ($filteredArray as $row) {
        $dataArray[$row['account']] += $row['amount'];
    }

    return $dataArray;
}

/**
 * Calculates cumulative sum per month within a date range
 *
 * @param array $operationsArray Array with all operations
 * @param string $startDate Start date of the range
 * @param string $endDate End date of the range
 *
 * @return array
 */
function cumulativeSumPerMonth(array $operationsArray, string $startDate, string $endDate)
{
    $dataArray = [];
    $balance = 0;

    $startDateObj = new DateTime($startDate);
    $endDateObj = new DateTime($endDate);

    while ($startDateObj <= $endDateObj) {
        $temp = filterByDate($operationsArray, $startDateObj->format("Y-m-d"), $startDateObj->modify('first day of +1 month')->format("Y-m-d"));

        if (!empty($temp)) {
            $balance += array_sum(array_column($temp, 'amount'));
            $dataArray[] =  [
                'date' => $startDateObj->format("Y.m"),
                'amount' => $balance
            ];
        }
    }

    return $dataArray;
}
