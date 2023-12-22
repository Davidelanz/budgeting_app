<?php

namespace Data\DataIO;


function dataDir(){
    return dirname(dirname(dirname(__FILE__)));
}

function dataFileCSV(){
    return dataDir() .  "/data/transactions.csv";
}

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
