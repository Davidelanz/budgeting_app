<?php


function uploadCSV()
{
    $uploadedFile = $_FILES["file"];

    if ($uploadedFile["error"] !== UPLOAD_ERR_OK) {
        return json_encode(["error" => "File upload error"]);
    }

    $tmpName = $uploadedFile["tmp_name"];
    $csvData = array_map("str_getcsv", file($tmpName));

    // Assuming the first row is headers
    $headers = array_shift($csvData);

    // Validate CSV headers
    $requiredHeaders = ["date", "operation", "amount", "account", "category", "subcategory", "note"];
    if ($headers !== $requiredHeaders) {
        return json_encode(["error" => "Invalid CSV format"]);
    }

    $transactions = [];

    foreach ($csvData as $row) {
        $transactions[] = array_combine($headers, $row);
    }

    \Data\DataIO\writeCSV($transactions);

    return json_encode(["success" => "CSV uploaded successfully"]);
}
