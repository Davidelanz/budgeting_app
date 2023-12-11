<?php

/**
 * Plotter Namespace
 *
 * This namespace contains functions for generating cumulative balance plots using Plotly.js.
 *
 * @package Plotter
 */

namespace Plotter;

/**
 * Generate Cumulative Balance Plot
 *
 * Generates a cumulative balance plot using Plotly.js based on the provided CSV data.
 *
 * @param array $csvData The CSV data containing date and amount information.
 *
 * @return void
 */
function generateCumulativeBalancePlot($csvData) {
    /**
     * Dates Array
     * @var array
     */
    $dates = [];

    /**
     * Amounts Array
     * @var array
     */
    $amounts = [];

    /**
     * Cumulative Amounts
     * @var int
     */
    $cumulativeAmounts = 0;

    // Extract dates and amounts from CSV data
    foreach ($csvData as $row) {
        // Assuming the date is in the first column, and amount is in the second column
        $date = $row[0];
        $amount = (int)$row[2]; // Convert amount to integer

        // Skip invalid or empty dates
        if (strtotime($date) === false) {
            continue;
        }

        $cumulativeAmounts += $amount;
        $dates[] = $date;
        $amounts[] = $cumulativeAmounts;
    }

    // Convert dates to JavaScript format (YYYY-MM-DD)
    $jsDates = array_map(function ($date) {
        return date('Y-m-d', strtotime($date));
    }, $dates);

    // Create JavaScript code for Plotly.js
    $jsCode = "
        <div id='balance-plot'></div>
        <script>
            var dates = " . json_encode($jsDates) . ";
            var amounts = " . json_encode($amounts) . ";

            var trace = {
                x: dates,
                y: amounts,
                type: 'scatter',
                mode: 'lines+markers',
                line: { shape: 'linear' }
            };

            var layout = {
                title: 'Cumulative Balance Over Time',
                xaxis: { title: 'Date' },
                yaxis: { title: 'Cumulative Amount' }
            };

            var data = [trace];

            Plotly.newPlot('balance-plot', data, layout);
        </script>
    ";

    echo $jsCode;
}

/**
 * Bar Chart for Monthly Income and Expenses
 *
 * @param array $csvData The CSV data containing date, amount, and category information.
 *
 * @return void
 */
function generateMonthlyIncomeExpensesBarChart($csvData) {
    $monthlyData = [];

    foreach ($csvData as $row) {
        $date = $row[0];
        $amount = (int)$row[2];
        $category = $row[4]; // Assuming category is in the fourth column

        if (strtotime($date) === false) {
            continue;
        }

        $monthYear = date('Y-m', strtotime($date));

        if (!isset($monthlyData[$monthYear])) {
            $monthlyData[$monthYear] = ['income' => 0, 'expenses' => 0];
        }

        if ($amount > 0) {
            $monthlyData[$monthYear]['income'] += $amount;
        } else {
            $monthlyData[$monthYear]['expenses'] += abs($amount);
        }
    }

    $months = array_keys($monthlyData);
    $income = array_column($monthlyData, 'income');
    $expenses = array_column($monthlyData, 'expenses');

    $jsCode = "
        <div id='monthly-income-expenses-bar-chart'></div>
        <script>
            var months = " . json_encode($months) . ";
            var income = " . json_encode($income) . ";
            var expenses = " . json_encode($expenses) . ";

            var trace1 = {
                x: months,
                y: income,
                name: 'Income',
                type: 'bar'
            };

            var trace2 = {
                x: months,
                y: expenses,
                name: 'Expenses',
                type: 'bar'
            };

            var layout = {
                title: 'Monthly Income and Expenses',
                xaxis: { title: 'Month' },
                yaxis: { title: 'Amount' },
                barmode: 'stack'
            };

            var data = [trace1, trace2];

            Plotly.newPlot('monthly-income-expenses-bar-chart', data, layout);
        </script>
    ";

    echo $jsCode;
}

/**
 * Pie Chart for Expense Categories
 *
 * @param array $csvData The CSV data containing date, amount, and category information.
 *
 * @return void
 */
function generateExpenseCategoriesPieChart($csvData) {
    $categoryData = [];

    foreach ($csvData as $row) {
        $amount = (int)$row[2];
        $category = $row[4]; // Assuming category is in the fourth column

        if ($amount < 0) {
            if (!isset($categoryData[$category])) {
                $categoryData[$category] = 0;
            }
            $categoryData[$category] += abs($amount);
        }
    }

    $categories = array_keys($categoryData);
    $amounts = array_values($categoryData);

    $jsCode = "
        <div id='expense-categories-pie-chart'></div>
        <script>
            var categories = " . json_encode($categories) . ";
            var amounts = " . json_encode($amounts) . ";

            var data = [{
                values: amounts,
                labels: categories,
                type: 'pie'
            }];

            var layout = {
                title: 'Expense Categories',
            };

            Plotly.newPlot('expense-categories-pie-chart', data, layout);
        </script>
    ";

    echo $jsCode;
}
