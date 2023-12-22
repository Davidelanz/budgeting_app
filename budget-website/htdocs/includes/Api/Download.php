<?php

namespace Api\Download;


function CSV()
{
    // Fetch data
    $transactions = \Data\DataIO\readCSV();

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="transactions.csv"');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0');
    header('Pragma: no-cache');

    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Output the headers
    fputcsv($output, ["date", "operation", "amount", "account", "category", "subcategory", "note"]);

    // Output the data
    foreach ($transactions as $transaction) {
        fputcsv($output, $transaction);
    }

    // Close the file pointer
    fclose($output);

    // Exit to prevent further output
    exit();
}
