function transpose(matrix) {
    // Transpose an array of arrays (i.e., a matrix)
    return matrix[0].map((col, i) => matrix.map(row => row[i]));
}

function defaultLayout() {
    // Layout configuration to remove margins and background color
    var layout = {
        margin: { l: 0, r: 0, b: 0, t: 0 },
        paper_bgcolor: 'rgba(0,0,0,0)', // make it transparent
        plot_bgcolor: 'rgba(0,0,0,0)', // make it transparent
    };
    return layout;
}

function createTransactionsTable(arrayOfArraysValues, targetElementId) {
    // Pop the first array containing headers
    headerValues = arrayOfArraysValues.splice(0, 1);
    // We expect arrayOfArraysValues as an array of array, but plotly likes the other way around
    headerValues = transpose(headerValues);
    transposedValues = transpose(arrayOfArraysValues);
    // Retrieve primary color assuming you have the CSS variable defined
    var primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary');
    // Create table data
    var tableData = [{
        type: 'table',
        header: {
            values: headerValues,
            fill: { color: primaryColor },
            font: { color: "white" }
        },
        cells: { values: transposedValues }
    }]
    // Generate plot
    Plotly.newPlot(targetElementId, tableData, defaultLayout());
}
