<?php
    /**
     * File contains class ValidateData
     */
    declare(strict_types=1);

	if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * ValidateData class
     *
     * ValidateData class contains public static methods for data validation.
     */
    Class Validate_helper
    {
        /**
         * validateString
         *
         * Method validates string. It returns true if argument is number
         * or argument is a type of string and has at least one character that is not empty space,
         * else it returns false.
         *
         * @access public
         * @static
         * @param mixed $string
         * @param integer $minLength
         * @return boolean
         */
        public static function validateString(mixed $string, int $minLength = 0): bool
        {
            if (!is_string($string)) return false;
            return (strlen(trim($string)) >= $minLength) ? true : false;
        }

        /**
         * validateInteger
         *
         * Method validates integer. It returns true if argument is integer or 0, else it returns false.
         * It uses filter_var() php internal function with FILTER_VALIDATE_INT filter.
         *
         * @link https://www.php.net/manual/en/filter.filters.validate.php
         * @access public
         * @static
         * @param mixed $integer Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateInteger(mixed $integer): bool
        {
            if (!is_numeric($float)) return false;
            if (filter_var($integer, FILTER_VALIDATE_INT) === 0 || filter_var($integer, FILTER_VALIDATE_INT)) {
                return true;
            }
            return false;
        }

        /**
         * validateFloat
         *
         * Method validates float. It returns true if argument is float or 0.0, else it returns false.
         * It uses filter_var() php internal function with FILTER_VALIDATE_FLOAT filter.
         *
         * @link https://www.php.net/manual/en/filter.filters.validate.php
         * @access public
         * @static
         * @param mixed $float Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateFloat(mixed $float): bool
        {
            if (!is_numeric($float)) return false;
            if (filter_var($float, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($float, FILTER_VALIDATE_FLOAT)) {
                return true;
            }
            return false;
        }

        /**
         * validateNumber
         *
         * Method validates number. It returns true if argument is integer, float, 0 or 0.0, else it returns false.
         * It uses ValidateData::validateInteger($number) and ValidateData::validateFloat($number) methods.
         *
         * @access public
         * @static
         * @param mixed $number Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateNumber(mixed $number): bool
        {
            if (self::validateInteger($number) || self::validateFloat($number)) {
                return true;
            }
            return false;
        }

        /**
         * validateEmail
         *
         * Method validates email. It returns true if argument is valid email, else it returns false.
         * It uses filter_var() php internal function with FILTER_VALIDATE_EMAIL filter.
         *
         * @link https://www.php.net/manual/en/filter.filters.validate.php
         * @access public
         * @static
         * @param string $email Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateEmail(string $email): bool
        {
            return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
        }

        /**
         * validatePassword
         *
         * Method validates password.
         * Password must have passwordLength or more characters, at least one number and at least one upper case.
         * It returns true if all conditions are met, else it returns false.
         *
         * @access public
         * @static
         * @param string $password Argument is required.
         * @param int $passwordLength Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validatePassword(string $password, int $passwordLength): bool
        {
            if ( strlen($password) >= $passwordLength && strpbrk($password, '0123456789') && strtolower($password) !== $password ) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * validateDate
         *
         * Method validates date. It returns true if argument is valid date, else it returns false.
         *
         * @access public
         * @static
         * @param string $date Argument is required.
         * @return bool Method returns true or false.
         */
        public static function validateDate(string $date): bool
        {
            $date = trim($date);
            return strtotime($date) ? true : false;
        }

        public static function validatePhoneNumber(string $string, int $minLength ): bool
        {
            if (!ctype_digit($string)) return false;
            if (strlen(trim($string)) < $minLength) return false;
            return true;
        }
    }
