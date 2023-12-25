<?php

namespace Api\Download;

/**
 * Generates and initiates the download of a CSV file containing transaction data.
 *
 * This function reads transaction data, sets appropriate CSV download headers, and outputs
 * the data to the browser for download. The CSV file includes headers: date, operation, amount,
 * account, category, subcategory, and note.
 *
 * @return void This function does not return a value but exits to prevent further output.
 */
function CSV()
{
    // Fetch transaction data from CSV
    $transactions = \Data\DataIO\readCSV();

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="transactions.csv"');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0');
    header('Pragma: no-cache');

    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Output CSV headers
    fputcsv($output, ["date", "operation", "amount", "account", "category", "subcategory", "note"]);

    // Output transaction data
    foreach ($transactions as $transaction) {
        fputcsv($output, $transaction);
    }

    // Close the file pointer
    fclose($output);

    // Exit to prevent further output
    exit();
}
