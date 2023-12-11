<?php

/**
 * CsvReader Namespace
 *
 * This namespace contains functions for reading and displaying CSV data.
 *
 * @package CsvReader
 */

namespace CsvReader;

/**
 * Read CSV File
 *
 * Reads a CSV file and returns its data as an associative array.
 *
 * @param string $filename The path to the CSV file.
 *
 * @return array An associative array representing the CSV data.
 */
function readCSV($filename) {
    /**
     * CSV Data Array
     * @var array
     */
    $csvData = [];

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $csvData[] = array_map('trim', $row);
        }
        fclose($handle);
    }

    return $csvData;
}

/**
 * addEntry function appends a new entry to a CSV file.
 *
 * @param string $csvPath - The path to the CSV file.
 * @param array $data - An associative array representing the entry to be added.
 * @param array $columns - An indexed array representing the order of columns in the CSV.
 *
 * @return bool - Returns true if the entry is successfully added, false otherwise.
 */
function addEntry(string $csvPath, array $data, array $columns)
{
    // Open the CSV file for appending.
    $file = fopen($csvPath, "a");

    // Check if the array and columns are not empty.
    if (!empty($data) && !empty($columns)) {

        // Iterate through columns to write data to the CSV file.
        foreach ($columns as $column) {
            // Check if the column exists in the data array.
            if (array_key_exists($column, $data)) {
                // Write the data to the file followed by a comma.
                fwrite($file, $data[$column] . ",");
            } else {
                // If the column does not exist in the data, write an empty string followed by a comma.
                fwrite($file, ",");
            }
        }

        // Move to the next line in the CSV file.
        fwrite($file, "\n");

        // Close the file.
        fclose($file);

        // Return true to indicate successful entry addition.
        return true;
    }

    // Close the file in case of empty data or columns.
    fclose($file);

    // Return false to indicate failure in adding the entry.
    return false;
}

/**
 * Display CSV Data in Bootstrap 5 Table
 *
 * Displays CSV data in a Bootstrap 5 table format.
 *
 * @param array $csvData The CSV data to be displayed.
 *
 * @return void
 */
function displayCSVTable($csvData) {
    echo '<table class="table table-bordered table-striped">';
    echo '<thead><tr>';

    // Display table headers
    foreach ($csvData[0] as $header) {
        echo '<th>' . htmlspecialchars($header) . '</th>';
    }

    echo '</tr></thead><tbody>';

    // Display table rows
    for ($i = 1; $i < count($csvData); $i++) {
        echo '<tr>';
        foreach ($csvData[$i] as $value) {
            echo '<td>' . htmlspecialchars($value) . '</td>';
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
}

?>
