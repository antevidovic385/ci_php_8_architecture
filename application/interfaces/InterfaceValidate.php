<?php
    declare(strict_types=1);

    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    Interface InterfaceValidate
    {
        public function validateDataForInsert(array $data): ?object;
        public function validateData(array $data): ?object;
        public function validateProperty(string $property, mixed $value): ?object;
    }
