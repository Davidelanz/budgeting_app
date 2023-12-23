/**
 * Transposes an array of arrays (matrix).
 *
 * This function takes a matrix as input and transposes it, swapping rows and columns.
 *
 * @param {Array} matrix - The input matrix to be transposed.
 * @returns {Array} - The transposed matrix.
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
 * Creates a Plotly table from an array of arrays and appends it to the specified HTML element.
 *
 * This function takes an array of arrays as input, assumes the first array contains headers,
 * transposes the data, and creates a Plotly table. It then appends the table to the specified
 * HTML element identified by the targetElementId.
 *
 * @param {Array} arrayOfArraysValues - An array of arrays containing table data.
 * @param {string} targetElementId - The HTML element ID where the table should be appended.
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
