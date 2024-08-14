<?php

namespace Amm\NumericCode;

class NumericCode
{
    private static int $twoDigitsCount;
    private static int $consecutiveNumsCount;

    public static function generate(string $template)
    {
        self::$twoDigitsCount = 0;
        self::$consecutiveNumsCount = 0;

        $template = trim($template);
        $count = substr_count($template, '#');
        $numbers = self::numbersGenerator($count);

        $pos = strpos($template, '#');
        while ($pos !== false) {
            $template = substr_replace($template, array_shift($numbers), $pos, 1);
            $pos = strpos($template, '#');
        }
        var_dump($template);
    }


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

//        do {
//            $code = [];
//            for ($i = 0; $i < $count; $i++) {
//                $code[] = rand(1, 9);
//            }
//        } while (self::verify_code($code, $count));

    }

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
            self::$consecutiveNumsCount++;
        }

        return true;

    }

    /**
     * @param array $array
     * @param mixed $search
     * @param bool $strict default is true
     * @return int
     */
    private static function getCountInArray(array $array, mixed $search, bool $strict = true): int
    {
        $i = 0;
        foreach ($array as $item) {
            if (
                ($strict and $item === $search)
                or
                (!$strict and $item == $search)
            )
                $i++;
        }
        return $i;
    }

}

NumericCode::generate('hi#am#m#');




//        for ($i = 0; $i < $count; $i++) {
//
//            if (array_count_values($code)[$code[$i]] > 2) {
//                return false;
//            } elseif (
//                ($i > 0 && $i < $count - 1) &&
//                (($code[$i] - $digits[$i - 1]) ** 2) == 1 &&
//                (($code[$i] - $digits[$i + 1]) ** 2) == 1
//            ) {
//                return false;
//            }
//        }
//        return true;