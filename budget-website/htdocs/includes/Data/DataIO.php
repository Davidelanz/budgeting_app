<?php

namespace Data\DataIO;

/**
 * Retrieves the path to the data directory.
 *
 * @return string The absolute path to the data directory.
 */
function dataDir()
{
    return dirname(dirname(dirname(__FILE__)));
}

/**
 * Retrieves the path to the CSV data file.
 *
 * @return string The absolute path to the CSV data file.
 */
function dataFileCSV()
{
    return dataDir() .  "/data/transactions.csv";
}

/**
 * Reads data from the CSV file and returns an array of transactions.
 *
 * This function reads data from the CSV file specified by `dataFileCSV()`. It parses
 * the CSV file, extracts headers, and creates an associative array for each row of data.
 * The resulting array represents transactions.
 *
 * @return array An array of transactions, where each transaction is represented as an associative array.
 * @throws \Exception if the CSV file is not found.
 */
function readCSV()
{
    $csvFile = dataFileCSV();

    if (!file_exists($csvFile)) {
        throw new \Exception("CSV file $csvFile not found");
    }

    $csvData = array_map("str_getcsv", file($csvFile));
    $csvHeaders = array_shift($csvData);
    $transactions = [];

    foreach ($csvData as $row) {
        $transactions[] = array_combine($csvHeaders, $row);
    }

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
 */
function writeCSV($data)
{
    $csvFile = dataFileCSV();
    $csv = fopen($csvFile, "w");

    // Write headers
    fputcsv($csv, array_keys($data[0]));

    // Write data
    foreach ($data as $row) {
        fputcsv($csv, $row);
    }

    fclose($csv);
}
