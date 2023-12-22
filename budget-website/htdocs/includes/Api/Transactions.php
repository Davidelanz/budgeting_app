<?php

namespace Api\Transactions;

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
