<?php

namespace AmMokhtari\NumericCode;

use Exception;

class NumericCode
{
    private static array $possibleNumbers;
    private static bool $twoDigitsCount;
    private static bool $consecutiveNumsCount;

    /**
     * @throws Exception
     */
    private function __construct()
    {
    }

    /**
     * @param int $length : amount of code
     * @throws Exception
     */
    public static function generate(int $length): string
    {
        if ($length > 8 || $length < 1)
            throw new Exception('Digits must be between 1 and 8', 400); // Use 400 for invalid input
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

    private static function selectValidDigit(array $selections, array &$code, int $length): int|string
    {
        shuffle($selections);
        foreach ($selections as $digit) {
            if (self::isValidDigit($digit, $code)) {
                return $digit;
            }
        }
        throw new Exception("Failed to generate a valid numeric code after multiple attempts due to unsatisfiable constraints", 500);
    }

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

    private static function removeImpossible(int $digit): void
    {
        unset(self::$possibleNumbers[$digit - 1]);
    }
}