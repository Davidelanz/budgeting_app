<?php

namespace Data\Validator;

/**
 * Validates transfer transactions and identifies possible wrong entries.
 *
 * This function checks for transfer transactions where a negative amount
 * from an account does not have a corresponding transfer transaction
 * to another account on the same day with the same positive amount.
 *
 * @param array $transactions - An array of transactions in the specified CSV format.
 * @return array - An array containing details of possible wrong entries.
 */
function validateTransfers($transactions)
{
    $wrongEntries = [];

    // Floating-point numbers can sometimes have precision issues,
    // and comparing them directly might lead to unexpected behavior.
    // To address this, you can use a small threshold for the amount
    // comparison instead of strict equality:
    $amountThreshold = 0.01; // Adjust this threshold as needed

    foreach ($transactions as $transaction) {
        $date = $transaction['date'];
        $amount = (float)$transaction['amount'];
        $account = $transaction['account'];
        $operation = $transaction['operation'];

        // Check only transfer transactions
        if ($operation === 'transfer') {
            // Define a function to check for a corresponding transfer transaction
            $isCorrespondingTransfer = function ($t) use ($date, $amount, $account, $amountThreshold) {
                // Check if it's the same day, amount is the same with opposite sign,
                // the account is different, and it's a transfer
                return $t['date'] === $date &&
                    abs((float)$t['amount'] + $amount) < $amountThreshold &&
                    $t['account'] !== $account &&
                    $t['operation'] === 'transfer';
            };

            // Filter transactions to find corresponding transfer transactions
            $correspondingTransaction = array_filter($transactions, $isCorrespondingTransfer);

            // If not found, add to wrong entries
            if (empty($correspondingTransaction)) {
                $wrongEntries[] = $transaction;
            }
        }
    }

    return $wrongEntries;
}

