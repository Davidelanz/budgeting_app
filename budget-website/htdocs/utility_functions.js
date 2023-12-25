/**
 * @module Utilities
 * @description A module providing utility functions.
 */


/**
 * Returns a string representation of a date in the format 'YYYY-MM-DD'.
 *
 * @param {Date} date - The input date.
 * @returns {string} - The date string in 'YYYY-MM-DD' format.
 * @function
 * @name dateToQueryString
 * @memberof Utilities
 * @example
 * const currentDate = new Date();
 * const dateString = dateToQueryString(currentDate);
 * console.log(dateString); // Outputs a string like '2022-01-01'
 */
function dateToQueryString(date) {
    return date.toISOString().split('T')[0];
}

/**
 * Returns a Date object representing the first day of the current month.
 *
 * @returns {Date} - A JavaScript Date object set to the first day of the current month.
 * @function
 * @name startOfThisMonth
 * @memberof Utilities
 * @example
 * const currentDate = new Date();
 * const firstDayOfMonth = startOfThisMonth(currentDate);
 * console.log(firstDayOfMonth); // Outputs a Date object for the first day of the current month
 */
function startOfThisMonth() {
    const currentDate = new Date();
    return new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
}

/**
 * Returns a Date object representing the last day of the current month, effectively the end of the current month.
 *
 * @returns {Date} - A JavaScript Date object set to the last day of the current month.
 * @function
 * @name endOfThisMonth
 * @memberof Utilities
 * @example
 * const currentDate = new Date();
 * const lastDayOfMonth = endOfThisMonth(currentDate);
 * console.log(lastDayOfMonth); // Outputs a Date object for the last day of the current month
 */
function endOfThisMonth() {
    const currentDate = new Date();
    const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
    return lastDay;
}


/**
 * Returns a Date object representing the first day of the current year.
 *
 * @returns {Date} - A JavaScript Date object set to the first day of the current year.
 * @function
 * @name startOfThisYear
 * @memberof Utilities
 * @example
 * const currentDate = new Date();
 * const firstDayOfYear = startOfThisYear(currentDate);
 * console.log(firstDayOfYear); // Outputs a Date object for the first day of the current year
 */
function startOfThisYear() {
    const currentDate = new Date();
    const firstDay = new Date(currentDate.getFullYear(), 0, 1);
    return firstDay;
}

/**
 * Returns a Date object representing the last day of the current year, effectively the end of the current year.
 *
 * @returns {Date} - A JavaScript Date object set to the last day of the current year.
 * @function
 * @name endOfThisYear
 * @memberof Utilities
 * @example
 * const currentDate = new Date();
 * const lastDayOfYear = endOfThisYear(currentDate);
 * console.log(lastDayOfYear); // Outputs a Date object for the last day of the current year
 */
function endOfThisYear() {
    const currentDate = new Date();
    const lastDay = new Date(currentDate.getFullYear(), 11, 31);
    return lastDay;
}
