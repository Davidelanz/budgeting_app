<?php

namespace Data\DataIO;

/**
 * Retrieves the path to the data directory.
 *
 * @return string The absolute path to the data directory.
 */
function dataDir()
{
    return dirname(dirname(dirname(__FILE__))) . "/data/";
}

/**
 * Reads data from all CSV files in the folder and returns an array of transactions.
 *
 * This function reads data from all CSV files in the folder specified by `dataFolderCSV()`.
 * It parses each CSV file, extracts headers, and creates an associative array for each row of data.
 * The resulting arrays are then merged to represent all transactions.
 *
 * @return array An array of transactions, where each transaction is represented as an associative array.
 * @throws \Exception if a CSV file is not found or if the CSV files have different columns.
 */
function readCSV()
{
    $folder = dataDir();
    $csvFiles = glob($folder . '*.csv');

    if (empty($csvFiles)) {
        throw new \Exception("No CSV files found in the folder $folder");
    }

    $transactions = [];

    // Initialize columns array with the columns of the first CSV
    $columns = array_keys(array_flip(array_map('str_getcsv', file($csvFiles[0]))[0]));

    foreach ($csvFiles as $csvFile) {
        $csvData = array_map("str_getcsv", file($csvFile));
        $csvHeaders = array_shift($csvData);

        // Check if the CSV has the same columns as the first one
        if ($columns !== array_keys(array_flip($csvHeaders))) {
            throw new \Exception("CSV files have different columns");
        }

        // Merge transactions from the current CSV
        foreach ($csvData as $row) {
            $transactions[] = array_combine($csvHeaders, $row);
        }
    }

    // Sort transactions by ascending dates
    usort($transactions, function ($a, $b) {
        $dateA = strtotime($a['date']); // Assuming 'date' is the key for the date field
        $dateB = strtotime($b['date']);
        return $dateA - $dateB;
    });

    return $transactions;

    return $transactions;
}

/**
 * Writes data to the CSV file.
 *
 * This function writes data to the CSV file specified by `dataFileCSV()`. It takes an array
 * of data, which should include an associative array for each row of data. The first row of the
 * data array is treated as headers, and subsequent rows represent data.
 *
 * @param array $data An array of data to be written to the CSV file.
 * @param string $filename The name of the CSV file.
 * @throws \Exception if the file already exists.
 */
function writeCSV($data, $filename)
{
    $csvFile = dataDir() . $filename;

    // Check if the file already exists
    if (file_exists($csvFile)) {
        throw new \Exception("File $filename already exists. Cannot overwrite an existing file.");
    }

    $csv = fopen($csvFile, "w");

    // Write headers
    fputcsv($csv, array_keys($data[0]));

    // Write data
    foreach ($data as $row) {
        fputcsv($csv, $row);
    }

    fclose($csv);
}
