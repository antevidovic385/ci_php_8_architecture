<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * Sanitize_helper
     *
     * Sanitize_helper class contains public static methods that are used in application.
     *
     * @author Ante VIDOVIĆ <antevidovic@gmail.com>
     */
    Class Sanitize_helper
    {
        /**
         * sanitizeData
         *
         * Method sanitizes data to prevents XSS attack. It takes $data as argument
         *
         * @static
         * @access public
         * @param string $data Argument is requried.
         * @return string|null Method returns string or null
         */
        public static function sanitizeData(mixed $data): ?string
        {
            if (is_string($data) || is_numeric($data)) {
                $CI =& get_instance();
                $sanitizeData = $CI->security->xss_clean($data);
                return $sanitizeData;
            }
            return null;
        }

        /**
         * sanitizePhpInput
         *
         * Method sanitize "php://input" to prevent XSS attack.
         *
         * @static
         * @access public
         * @return array|null
         */
        public static function sanitizePhpInput(): ?array
        {
            $CI =& get_instance();
            $data = trim(file_get_contents("php://input"));
            if (empty($data)) return null;
            $data = $CI->security->xss_clean($data);
            $data = json_decode($data, true);
            return $data;
        }

        public static function sanitizePost(): array
        {
            $CI =& get_instance();
            $post = [];
            foreach ($_POST as $key => $value) {
                $post[$key] = $CI->input->post($key, true);
            };
            return $post;
        }

        public static function sanitizeGet(): array
        {
            $CI =& get_instance();
            $get = [];
            foreach ($_GET as $key => $value) {
                $get[$key] = $CI->input->get($key, true);
            };
            return $get;
        }
    }
