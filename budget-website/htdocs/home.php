<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budgeting Web App</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Plotly -->
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="./plotly_functions.js"></script>
    <!-- Tables -->
    <script src="./table_functions.js"></script>
</head>

<body>

    <header>
        <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    Budget Web App
                </a>
            </div>
        </div>
    </header>

    <main role="main">

        <div class="album py-5 bg-light">
            <div class="container">

                <!-- Welcome card -->
                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <h2 class="card-title m-4 mb-1">Welcome to the Budgeting Web App</h2>
                            <div class="card-body mx-2 pt-2">
                                <p>This is a simple budgeting web app that allows you to manage your transactions.</p>
                                <?= Api\generateApiDocumentation(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Time Overall card -->
                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <h2 class="card-title m-4 mb-1">Overall</h2>
                            <div class="card-body mx-2 pt-2">
                                <code>
                                    &nbsp;___&nbsp;&nbsp;___&nbsp;&nbsp;&nbsp;___&nbsp;&nbsp;_&nbsp;__<br>
                                    / __|/ _ \ / _ \| '_ \ <br>
                                    \__ \ (_) | (_) | | | |<br>
                                    |___/\___/ \___/|_| |_|<br>
                                </code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Last 5 Months by Category card -->
                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <h2 class="card-title m-4 mb-1">Last Five Months by Category</h2>
                            <div class="card-body mx-2 pt-2">
                                <code>
                                    &nbsp;___&nbsp;&nbsp;___&nbsp;&nbsp;&nbsp;___&nbsp;&nbsp;_&nbsp;__<br>
                                    / __|/ _ \ / _ \| '_ \ <br>
                                    \__ \ (_) | (_) | | | |<br>
                                    |___/\___/ \___/|_| |_|<br>
                                </code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Last 3 Years by Category card -->
                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <h2 class="card-title m-4 mb-1">Last Three Years by Category</h2>
                            <div class="card-body mx-2 pt-2">
                                <code>
                                    &nbsp;___&nbsp;&nbsp;___&nbsp;&nbsp;&nbsp;___&nbsp;&nbsp;_&nbsp;__<br>
                                    / __|/ _ \ / _ \| '_ \ <br>
                                    \__ \ (_) | (_) | | | |<br>
                                    |___/\___/ \___/|_| |_|<br>
                                </code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- All Transactions card -->
                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <h2 class="card-title m-4 mb-1">All Transactions</h2>
                            <div class="card-body mx-2 pt-2">
                                <p><a href="/api/transactions.json"><code>GET /api/transactions.json</code></a></p>
                                <div id="transactionsTable">
                                    <!-- Plotly table -->
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        fetch("/api/transactions.json")
                                            .then(response => response.json())
                                            .then(data => {
                                                createTransactionsTable(data, "transactionsTable");
                                            })
                                            .catch(error => console.error("Error fetching data:", error));
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories card -->
                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <h2 class="card-title m-4 mb-1">Categories</h2>
                            <div class="card-body mx-2 pt-2">
                                <p><a href="/api/categories.json"><code>GET /api/categories.json</code></a></p>
                                <details>
                                    <summary>Show Table</summary>
                                    <style>
                                        #categoryTable {
                                            padding-top: 10pt;
                                            font-size: 10pt;
                                        }

                                        #categoryTable th,
                                        #categoryTable td {
                                            padding-top: 0px;
                                            padding-bottom: 0px;
                                        }
                                    </style>
                                    <table class="table mt-2" id="categoryTable">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Subcategory</th>
                                            </tr>
                                        </thead>
                                        <tbody id="categoryTableBody">
                                            <!-- This is where the table body will be appended -->
                                        </tbody>
                                    </table>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            fetch("/api/categories.json")
                                                .then(response => response.json())
                                                .then(data => {
                                                    generateCategoryTable(data, "categoryTableBody");
                                                })
                                                .catch(error => console.error("Error fetching data:", error));
                                        });
                                    </script>
                                </details>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accounts & Operations card -->
                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <h2 class="card-title m-4 mb-1">Accounts & Operations</h2>
                            <div class="card-body mx-2 pt-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><a href="/api/accounts.json"><code>GET /api/accounts.json</code></a></p>
                                        <details>
                                            <summary>Show Table</summary>
                                            <style>
                                                #accountsTable {
                                                    padding-top: 10pt;
                                                    font-size: 10pt;
                                                }

                                                #accountsTable th,
                                                #accountsTable td {
                                                    padding-top: 0px;
                                                    padding-bottom: 0px;
                                                }
                                            </style>
                                            <table class="table mt-2" id="accountsTable">
                                                <thead>
                                                    <tr>
                                                        <th>Accounts</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="accountsTableBody">
                                                    <!-- This is where the table body will be appended -->
                                                </tbody>
                                            </table>
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    fetch("/api/accounts.json")
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            generateAccountsTable(data, "accountsTableBody");
                                                        })
                                                        .catch(error => console.error("Error fetching data:", error));
                                                });
                                            </script>
                                        </details>
                                    </div>
                                    <div class="col-md-6">
                                        <p><a href="/api/operations.json"><code>GET /api/operations.json</code></a></p>
                                        <details>
                                            <summary>Show Table</summary>
                                            <style>
                                                #operationsTable {
                                                    padding-top: 10pt;
                                                    font-size: 10pt;
                                                }

                                                #operationsTable th,
                                                #operationsTable td {
                                                    padding-top: 0px;
                                                    padding-bottom: 0px;
                                                }
                                            </style>
                                            <table class="table mt-2" id="operationsTable">
                                                <thead>
                                                    <tr>
                                                        <th>Operations</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="operationsTableBody">
                                                    <!-- This is where the table body will be appended -->
                                                </tbody>
                                            </table>
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    fetch("/api/operations.json")
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            generateOperationsTable(data, "operationsTableBody");
                                                        })
                                                        .catch(error => console.error("Error fetching data:", error));
                                                });
                                            </script>
                                        </details>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>

</html>