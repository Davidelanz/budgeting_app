/**
 * Generates a category table and appends it to the specified HTML element.
 *
 * This function takes a data object containing categories and their subcategories
 * and generates an HTML table. It appends the table to the specified HTML element
 * identified by the targetElementId.
 *
 * @param {Object} data - An object containing categories and their subcategories.
 * @param {string} targetElementId - The HTML element ID where the table should be appended.
 */
function generateCategoryTable(data, targetElementId) {
    var tableBody = document.getElementById(targetElementId);

    for (var category in data) {
        // Create category row
        var categoryRow = document.createElement("tr");
        var categoryCell = document.createElement("td");
        categoryCell.innerHTML = '<strong>' + category + '</strong>';
        categoryRow.appendChild(categoryCell);
        categoryRow.appendChild(document.createElement("td")); // Empty cell for subcategories

        // Append category row
        tableBody.appendChild(categoryRow);

        // Create and append subcategory rows
        for (var i = 0; i < data[category].length; i++) {
            var subcategoryRow = document.createElement("tr");
            subcategoryRow.appendChild(document.createElement("td")); // Empty cell for category
            var subcategoryCell = document.createElement("td");
            subcategoryCell.innerHTML = '<i>' + data[category][i] + '</i>';
            subcategoryRow.appendChild(subcategoryCell);

            // Append subcategory row
            tableBody.appendChild(subcategoryRow);
        }
    }
}

/**
 * Generates an operations table and appends it to the specified HTML element.
 *
 * This function takes an array of operations and generates an HTML table. It appends
 * the table to the specified HTML element identified by the targetElementId.
 *
 * @param {Array} data - An array of operations.
 * @param {string} targetElementId - The HTML element ID where the table should be appended.
 */
function generateOperationsTable(data, targetElementId) {
    var tableBody = document.getElementById(targetElementId);

    for (var operation of data) {
        // Create operation row
        var operationRow = document.createElement("tr");
        var operationCell = document.createElement("td");
        operationCell.innerHTML = '<i>' + operation + '</i>';
        operationRow.appendChild(operationCell);

        // Append operation row
        tableBody.appendChild(operationRow);
    }
}

/**
 * Generates an accounts table and appends it to the specified HTML element.
 *
 * This function takes an array of accounts and generates an HTML table. It appends
 * the table to the specified HTML element identified by the targetElementId.
 *
 * @param {Array} data - An array of accounts.
 * @param {string} targetElementId - The HTML element ID where the table should be appended.
 */
function generateAccountsTable(data, targetElementId) {
    var tableBody = document.getElementById(targetElementId);

    for (var operation of data) {
        // Create operation row
        var operationRow = document.createElement("tr");
        var operationCell = document.createElement("td");
        operationCell.innerHTML = '<i>' + operation + '</i>';
        operationRow.appendChild(operationCell);

        // Append operation row
        tableBody.appendChild(operationRow);
    }
}
