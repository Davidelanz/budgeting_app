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

                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <h2 class="card-title m-4 mb-2">Welcome to the Budgeting Web App</h2>
                            <div class="card-body m-2">
                                <p>This is a simple budgeting web app that allows you to manage your transactions.</p>
                                <p>The following API endpoints are available:</p>
                                <ul>
                                    <li><a href="/api/download.csv"><code>GET /api/download.csv</code></a> - Download CSV data</li>
                                    <li><a href="/api/transactions.json"><code>GET /api/transactions.json</code></a> - Get transaction data based on date range</li>
                                </ul>
                                <p>The following API endpoints are being prototyped:</p>
                                <ul>
                                    <li><a href="/api/operations.json"><code>GET /api/operations.json</code></a> - List all unique operation types</li>
                                    <li><a href="/api/accounts.json"><code>GET /api/accounts.json</code></a> - List all unique account names</li>
                                    <li><a href="/api/categories.json"><code>GET /api/categories.json</code></a> - List all unique category names</li>
                                    <li><a href="/api/categories/subcategories.json"><code>GET /api/categories/subcategories.json</code></a> - List all unique subcategory names grouped by category</li>
                                    <li><a href="/api/subcategories.json"><code>GET /api/subcategories.json</code></a> - List all unique subcategory names</li>
                                    <li><a href="/api/transactions.json"><code>GET /api/transactions.json</code></a> - Get transaction data based on date range</li>
                                    <li><a href="/api/upload.csv"><code>POST /api/upload.csv</code></a> - Upload CSV data</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="card mb-4 box-shadow">
                            <h2 class="card-title m-4 mb-2">Transactions table</h2>
                            <div class="card-body m-2">
                                <p><a href="/api/transactions.json"><code>GET /api/transactions.json</code></a></p>
                                <div id="transactionsTable"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>


<script>
    // Create transactionsTable
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/transactions.json')
            .then(response => response.json())
            .then(data => {
                createTransactionsTable(data, 'transactionsTable');
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>

</html>
