<?php

namespace AmMokhtari\NumericCode;

use Exception;

class NumericCode
{
    private static array $code;
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
            throw new Exception('Digits must be more than 1 and at most 8', 403);

        self::$possibleNumbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        self::$code = [];
        self::$twoDigitsCount = false;
        self::$consecutiveNumsCount = false;

        for ($i = 0; $i < $length; $i++)
            self::$code[] = self::getNumber(self::$possibleNumbers, $length);
        return implode('', self::$code);
    }

    /**
     * @throws Exception
     */
    private static function getNumber(array $selections, int $length): int
    {
        $count = count($selections);
        if ($count === 0) {
            self::fail($length);
            exit();
        }
        $key = rand(0, $count - 1);
        $digit = $selections[$key];
        if (self::verify_code($digit))
            return $digit;
        unset($selections[$key]);
        return self::getNumber(array_values($selections), $length);
    }

    private static function verify_code(int $digit): bool
    {
        $lastValue = end(self::$code);
        if ($lastValue !== false) {
            $digitCount = in_array($digit, self::$code);
            if ($digitCount && self::$twoDigitsCount) {
                self::removeImpossible($digit);
                return false;
            } elseif (abs($digit - $lastValue) === 1) {
                if (self::$consecutiveNumsCount)
                    return false;
                self::$consecutiveNumsCount = true;
            }
            if ($digitCount) {
                self::$twoDigitsCount = true;
                self::removeImpossible($digit);
            }
        }
        return true;
    }

    private static function removeImpossible(int $digit): void
    {
        unset(self::$possibleNumbers[array_search($digit, self::$possibleNumbers)]);
        self::$possibleNumbers = array_values(self::$possibleNumbers);
    }

    /**
     * @throws Exception
     */
    private static function fail(int $length): void
    {
        static $fail = 0;
        $fail++;
        if ($fail > 2)
            throw new Exception("The program tried 3 times but didn't find a numeric code!", 500);
        self::generate($length);
        exit();
    }
}