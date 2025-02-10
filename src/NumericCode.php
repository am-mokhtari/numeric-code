<?php

namespace AmMokhtari\NumericCode;

use Exception;

/**
 * Class NumericCode
 * This class generates a numeric code based on specific constraints.
 * The generated code must:
 * - Have a length between 1 and 8 digits.
 * - Not contain more than two occurrences of any digit.
 * - Not have consecutive numbers unless allowed once.
 */
class NumericCode
{
    /**
     * Array of possible numbers (1-9) that can be used in the numeric code.
     *
     * @var array
     */
    private static array $possibleNumbers;

    /**
     * Boolean flag indicating whether a digit has appeared twice in the code.
     *
     * @var bool
     */
    private static bool $twoDigitsCount;

    /**
     * Boolean flag indicating whether consecutive numbers have already appeared once in the code.
     *
     * @var bool
     */
    private static bool $consecutiveNumsCount;

    /**
     * Private constructor to prevent instantiation of this utility class.
     */
    private function __construct()
    {
    }

    /**
     * Generates a numeric code of the specified length.
     *
     * @param int $length The desired length of the numeric code (must be between 1 and 8).
     * @return string The generated numeric code as a string.
     * @throws Exception If the length is invalid or if no valid code can be generated.
     */
    public static function generate(int $length): string
    {
        if ($length > 8 || $length < 1) {
            throw new Exception('Digits must be between 1 and 8', 400); // Use 400 for invalid input
        }

        self::$possibleNumbers = range(1, 9);
        $code = [];
        self::$twoDigitsCount = false;
        self::$consecutiveNumsCount = false;

        for ($i = 0; $i < $length; $i++) {
            $digit = self::selectValidDigit(self::$possibleNumbers, $code, $length);
            $code[$digit] = $digit;
        }

        return implode('', $code);
    }

    /**
     * Selects a valid digit for the numeric code based on the given constraints.
     *
     * @param array $selections An array of possible digits to choose from.
     * @param array &$code The current state of the numeric code being generated.
     * @param int $length The total length of the numeric code.
     * @return int The selected valid digit.
     * @throws Exception If no valid digit can be found after multiple attempts.
     */
    private static function selectValidDigit(array $selections, array &$code, int $length): int
    {
        shuffle($selections); // Randomize the order of possible digits
        foreach ($selections as $digit) {
            if (self::isValidDigit($digit, $code)) {
                return $digit;
            }
        }

        throw new Exception("Failed to generate a valid numeric code after multiple attempts due to unsatisfiable constraints", 500);
    }

    /**
     * Validates whether a digit can be added to the numeric code based on the constraints.
     *
     * @param int $digit The digit to validate.
     * @param array &$code The current state of the numeric code being generated.
     * @return bool True if the digit is valid, False otherwise.
     */
    private static function isValidDigit(int $digit, array &$code): bool
    {
        if (!empty($code)) {
            if (isset($code[$digit]) && self::$twoDigitsCount) {
                self::removeImpossible($digit);
                return false;
            }

            $lastDigit = end($code);
            if (abs($digit - $lastDigit) === 1) {
                if (self::$consecutiveNumsCount) {
                    return false;
                }
                self::$consecutiveNumsCount = true;
            }

            if (isset($code[$digit])) {
                self::$twoDigitsCount = true;
                self::removeImpossible($digit);
            }
        }

        return true;
    }

    /**
     * Removes a digit from the list of possible numbers because it violates the constraints.
     *
     * @param int $digit The digit to remove.
     */
    private static function removeImpossible(int $digit): void
    {
        unset(self::$possibleNumbers[$digit - 1]);
    }
}