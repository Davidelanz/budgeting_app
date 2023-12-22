<?php



function getOperations()
{
    $transactions = \Data\DataIO\readCSV();
    $operations = array_unique(array_column($transactions, "operation"));
    return json_encode($operations);
}

function getAccounts()
{
    $transactions = \Data\DataIO\readCSV();
    $accounts = array_unique(array_column($transactions, "account"));
    return json_encode($accounts);
}

function getCategories()
{
    $transactions = \Data\DataIO\readCSV();
    $categories = array_unique(array_column($transactions, "category"));
    return json_encode($categories);
}

function getSubcategories()
{
    $transactions = \Data\DataIO\readCSV();
    $subcategories = array_unique(array_column($transactions, "subcategory"));
    return json_encode($subcategories);
}

function getSubcategoriesByCategory()
{
    $transactions = \Data\DataIO\readCSV();
    $categories = array_unique(array_column($transactions, 'category'));

    $subcategoriesByCategory = [];

    foreach ($categories as $category) {
        $subcategoriesByCategory[$category] = [];
    }

    foreach ($transactions as $transaction) {
        $category = $transaction['category'];
        $subcategory = $transaction['subcategory'];

        if (!in_array($subcategory, $subcategoriesByCategory[$category], true)) {
            $subcategoriesByCategory[$category][] = $subcategory;
        }
    }

    return json_encode($subcategoriesByCategory);
}


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
