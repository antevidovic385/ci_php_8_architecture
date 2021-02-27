<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Utility_helper
    {
        public static function resetArrayByKeyMultiple(array $arrays, string $key): array
        {
            if (empty($arrays)) return [];
            $reset = [];
            foreach($arrays as $array) {
                if (is_object($array)) {
                    $array = (array) $array;
                }
                if (!isset($reset[$array[$key]])) {
                    $reset[$array[$key]] = [];
                }
                array_push($reset[$array[$key]], $array);
            }
            return $reset;
        }

        /**
         * compareTwoDates
         *
         * Checks is first date less or equal to second date. Returns true if it is, else false.
         *
         * @param string $firtsDate
         * @param string $secondDate
         * @param boolean $equal
         * @return boolean
         */
        public static function compareTwoDates(string $firtsDate, string $secondDate, bool $equal = true): bool
        {
            $firtsDate = strtotime($firtsDate);
            $secondDate = strtotime($secondDate);

            if ($equal) {
                return ($firtsDate <= $secondDate);
            }
            return ($firtsDate < $secondDate);
        }

        public static function logMessage(string $file, string $message): int
        {
            $message = date('Y-m-d H:i:s') . ' => ' . $message . PHP_EOL;
            return file_put_contents($file, $message, FILE_APPEND);
        }

        public static function getAndUnsetValue(array &$array, string $key, string $type = ''): mixed
        {
            $value = $array[$key];
            unset($array[$key]);
            if ($type) self::setValue($type, $value);

            return $value;
        }

        public static function setValue(string $type, mixed &$value): void
        {
            if ($type === 'string') {
                $value = strval($value);
            } elseif ($type === 'int') {
                $value = intval($value);
            } elseif ($type === 'float') {
                $value = floatval($value);
            }

            return;
        }
    }
