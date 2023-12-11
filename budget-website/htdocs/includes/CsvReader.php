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

/**
 * Sort CSV Data by Date
 *
 * Sorts CSV data by the "date" column in ascending order.
 *
 * @param array $csvData The CSV data to be sorted.
 *
 * @return array The sorted CSV data.
 */
function sortCSVByDate($csvData) {
    usort($csvData, function ($a, $b) {
        $dateA = strtotime($a[0]);
        $dateB = strtotime($b[0]);

        return $dateA <=> $dateB;
    });

    return $csvData;
}
?>
