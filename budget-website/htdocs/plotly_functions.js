/**
 * @module PlotlyUtilities
 * @description A module providing utility functions for creating Plotly charts and tables.
 */

/**
 * Transposes an array of arrays (matrix).
 *
 * This function takes a matrix as input and transposes it, swapping rows and columns.
 *
 * @param {Array} matrix - The input matrix to be transposed.
 * @returns {Array} - The transposed matrix.
 * @function
 * @name transpose
 * @memberof PlotlyUtilities
 */
function transpose(matrix) {
    return matrix[0].map((col, i) => matrix.map(row => row[i]));
}

/**
 * Provides a default layout configuration for Plotly charts.
 *
 * This function returns a layout configuration object with specified margin and background color
 * to make the chart transparent.
 *
 * @returns {Object} - The default layout configuration for Plotly charts.
 * @function
 * @name defaultLayout
 * @memberof PlotlyUtilities
 */
function defaultLayout() {
    var layout = {
        margin: { l: 0, r: 0, b: 0, t: 0 },
        paper_bgcolor: 'rgba(0,0,0,0)', // make it transparent
        plot_bgcolor: 'rgba(0,0,0,0)', // make it transparent
    };
    return layout;
}

/**
 * Creates a line chart using Plotly to display cumulative amounts over time.
 *
 * This function expects an object with dates as keys and cumulative amounts as values.
 * It creates a line chart where the x-axis represents dates, the y-axis represents
 * cumulative amounts, and each point on the line represents the cumulative amount
 * at a specific date.
 *
 * @param {Object} data - An object with dates as keys and cumulative amounts as values.
 * @param {string} targetElementId - The HTML element ID where the line chart should be appended.
 * @function
 * @name createCumulativeChart
 * @memberof PlotlyUtilities
 * @example
 * const data = {
 *   "2021-11-01": 100,
 *   "2021-11-12": 90,
 *   "2021-12-01": 2817.46,
 *   // ... more data
 * };
 * createCumulativeChart(data, "lineChartElement");
 */
function createCumulativeChart(data, targetElementId) {
    // Extract dates and cumulative amounts
    var dates = Object.keys(data);
    var cumulativeAmounts = Object.values(data);

    // Convert dates to JavaScript Date objects for better handling
    var dateObjects = dates.map(date => new Date(date));

    // Create trace for the line chart
    var trace = {
        x: dateObjects,
        y: cumulativeAmounts,
        type: 'scatter',
        mode: 'lines',
        name: 'Cumulative Amount (EUR)',
    };

    // Create layout
    var layout = {
        title: 'Amount Over Time',
        margin: { l: 50, r: 20, b: 40, t: 40 },
        paper_bgcolor: 'rgba(0,0,0,0)', // make it transparent
        plot_bgcolor: 'rgba(0,0,0,0)', // make it transparent
        xaxis: {
            title: 'Date',
            type: 'date'
        },
        yaxis: {
            title: 'EUR',
        },
    };

    // Generate plot
    Plotly.newPlot(targetElementId, [trace], layout);
}

/**
 * Appends traces to an existing Plotly line chart to display cumulative amounts over time for multiple accounts.
 *
 * This function expects an object with account keys, where each key contains an object with dates as keys
 * and cumulative amounts as values. It appends a separate line for each account to the existing line chart.
 *
 * @param {Object} multiAccountData - An object with account keys, each containing an object with dates and cumulative amounts.
 * @param {string} targetElementId - The HTML element ID of the existing line chart to which traces will be appended.
 * @function
 * @name appendCumulativeChartByAccount
 * @memberof PlotlyUtilities
 * @example
 * const multiAccountData = {
 *   "Account1": {
 *     "2021-11-01": 100,
 *     "2021-11-12": 90,
 *     "2021-12-01": 2817.46,
 *     // ... more data
 *   },
 *   "Account2": {
 *     "2021-11-01": 50,
 *     "2021-11-12": 120,
 *     "2021-12-01": 2200.34,
 *     // ... more data
 *   },
 *   // ... more accounts
 * };
 * appendCumulativeChartByAccount(multiAccountData, "lineChartElement");
 */
function appendCumulativeChartByAccount(multiAccountData, targetElementId) {
    // Retrieve the graphDiv from the promise
    Plotly.plot(targetElementId, []).then((gd) => {
        for (const accountKey in multiAccountData) {
            const data = multiAccountData[accountKey];

            // Extract dates and cumulative amounts
            var dates = Object.keys(data);
            var cumulativeAmounts = Object.values(data);

            // Convert dates to JavaScript Date objects for better handling
            var dateObjects = dates.map(date => new Date(date));

            // Create trace for the line chart
            var trace = {
                x: dateObjects,
                y: cumulativeAmounts,
                type: 'scatter',
                mode: 'lines',
                name: accountKey,
            };

            // Add trace to existing plot
            Plotly.addTraces(gd, [trace]);
        }
    });
}

/**
 * Creates a histogram using Plotly based on category subtotals.
 *
 * This function expects an array of objects with category and subtotal properties.
 * It creates a bar chart where each bar represents a category, and the height
 * of the bar represents the subtotal for that category.
 *
 * @param {Array} subtotalValues - An array of objects with category and subtotal properties.
 * @param {string} targetElementId - The HTML element ID where the histogram should be appended.
 * @function
 * @name createCategoriesHistogram
 * @memberof PlotlyUtilities
 * @example
 * const subtotalValues = [
 *   {"category":"Food","subtotal":-770},
 *   {"category":"Other Income","subtotal":3860},
 *   {"category":"Investment Income","subtotal":4670},
 *   // ... more data
 * ];
 * createCategoriesHistogram(subtotalValues, "histogramElement");
 */
function createCategoriesHistogram(subtotalValues, targetElementId) {
    // Extract categories and subtotals
    var categories = subtotalValues.map(item => item.category);
    var subtotals = subtotalValues.map(item => item.subtotal);

    // Create trace for each category
    var traces = categories.map((category, index) => ({
        x: [category],
        y: [subtotals[index]],
        type: 'bar',
        name: category,
    }));

    // Create layout
    var layout = {
        barmode: 'stack',
        title: 'Stacked Histogram',
        xaxis: {
            title: 'Categories',
        },
        yaxis: {
            title: 'Subtotals',
        },
    };
    // Add the default customization
    var layout = { ...defaultLayout(), ...layout };

    // Generate plot
    Plotly.newPlot(targetElementId, traces, layout);
}

/**
 * Creates a Plotly table from an array of arrays and appends it to the specified HTML element.
 *
 * This function takes an array of arrays as input, assumes the first array contains headers,
 * transposes the data, and creates a Plotly table. It then appends the table to the specified
 * HTML element identified by the targetElementId.
 *
 * @param {Array} arrayOfArraysValues - An array of arrays containing table data.
 * @param {string} targetElementId - The HTML element ID where the table should be appended.
 * @function
 * @name createTransactionsTable
 * @memberof PlotlyUtilities
 * @example
 * const tableData = [
 *   ["date", "operation", "amount", "category"],
 *   ["2022-01-01", "income", 100, "Salary"],
 *   ["2022-01-02", "expense", 30, "Food"],
 *   // ... more data
 * ];
 * createTransactionsTable(tableData, "tableElement");
 */
function createTransactionsTable(arrayOfArraysValues, targetElementId) {
    // Pop the first array containing headers
    headerValues = arrayOfArraysValues.splice(0, 1);
    // We expect arrayOfArraysValues as an array of array, but plotly likes the other way around
    headerValues = transpose(headerValues);
    transposedValues = transpose(arrayOfArraysValues);
    // Retrieve header color assuming you have the CSS variable defined
    var headerColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-secondary');
    // Create table data
    var tableData = [{
        type: 'table',
        header: {
            values: headerValues,
            fill: { color: headerColor },
            font: { color: "white" }
        },
        cells: { values: transposedValues }
    }];
    // Generate plot
    Plotly.newPlot(targetElementId, tableData, defaultLayout());
}
