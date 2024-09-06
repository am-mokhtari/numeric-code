<?php

namespace AmMokhtari\NumericCode;

use Exception;

class NumericCode
{
    private static bool $twoDigitsCount;
    private static bool $consecutiveNumsCount;

    /**
     * @param string $template : # means digit
     * Digits must be at most 8
     * @return string
     * @throws Exception
     */
    public static function generate(string $template): string
    {
        self::$twoDigitsCount = false;
        self::$consecutiveNumsCount = false;
        $template = trim($template);
        $count = substr_count($template, '#');

        if ($count > 8) {
            throw new Exception('Digits must be at most 8');
        }

        $numbers = self::numbersGenerator($count);

        $pos = strpos($template, '#');
        while ($pos !== false) {
            $template = substr_replace($template, array_shift($numbers), $pos, 1);
            $pos = strpos($template, '#');
        }

        return $template;
    }

    /**
     * @param int $count
     * @return array
     */
    private static function numbersGenerator(int $count): array
    {
        if ($count < 1) {
            return [];
        }

        $code = [];
        for ($i = 0; $i < $count; $i++) {
            do {
                $digit = rand(1, 9);
            } while (!self::verify_code($code, $digit));
            $code[] = $digit;
        }

        return $code;
    }

    /**
     * @param array $code
     * @param int $digit
     * @return bool
     */
    private static function verify_code(array $code, int $digit): bool
    {
        if (empty($code))
            return true;

        $digitCount = self::getCountInArray($code, $digit);
        $lastKey = array_key_last($code);

        if ($digitCount > 1) {
            return false;

        } elseif ($digitCount === 1) {
            if (self::$twoDigitsCount > 0)
                return false;
            self::$twoDigitsCount++;

        } elseif (($digit - $code[$lastKey]) ** 2 === 1) {
            if (
                ($code[$lastKey] - $code[$lastKey - 1]) ** 2 === 1 or self::$consecutiveNumsCount > 0
            )
                return false;
            self::$consecutiveNumsCount = true;
        }

        return true;
    }

    /**
     * @param array $array
     * @param mixed $search
     * @return int
     */
    private static function getCountInArray(array $array, mixed $search): int
    {
        $i = 0;
        foreach ($array as $item) {
            if ($item === $search)
                $i++;
        }
        return $i;
    }

}
