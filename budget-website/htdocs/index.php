<?php
require_once dirname(__FILE__) . '/includes/CsvReader.php';
require_once dirname(__FILE__) . '/includes/Plotter.php';

$csvFile = dirname(__FILE__) . '/data/budget_entries.csv';
$csvData = CsvReader\readCSV($csvFile);
if (empty($csvData)) {
    echo 'Error reading CSV file.';
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Budgeting App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
</head>

<body>

    <header>
        <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    Budget App
                </a>
            </div>
        </div>
    </header>

    <main role="main">

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <div class="card-body">
                                <?= Plotter\generateCumulativeBalancePlot($csvData); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <div class="card-body">
                                <?= Plotter\generateMonthlyIncomeExpensesBarChart($csvData); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <div class="card-body">
                                <?= Plotter\generateExpenseCategoriesPieChart($csvData); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <div class="card-body">
                                <?= CsvReader\displayCSVTable($csvData); ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </main>

</body>

</html>
