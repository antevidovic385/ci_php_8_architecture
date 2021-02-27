<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH . 'abstract/Set.php';

    Abstract Class Validate extends Set
    {
        abstract protected function setDataProperty(array $data): void;
        abstract protected function insertValidate(array $data): bool;
        abstract protected function updateValidate(array $data): bool;

        private function checkForId(array $data): bool
        {
            return isset($data['id']) ? false : true;
        }

        private function checkForIntruders(array $data): bool
        {
            $publics = $this->getPublicPropertiesNames();
            $dataKeys = array_keys($data);
            $intruders = array_diff($dataKeys, $publics);

            return $intruders ? false : true;
        }

        private function callValidationMethod(array $data, bool $isInsert): bool
        {
            $call = $isInsert ? 'insertValidate' : 'updateValidate';
            
            return call_user_func_array([$this, $call], [$data]);
        }

        private function sanitizeAndValidate(array $data, bool $isInsert): ?self
        {
            $data = $this->security->xss_clean($data);

            if (
                !$this->checkForId($data)
                || !$this->checkForIntruders($data)
                || !$this->callValidationMethod($data, $isInsert)
            ) return null;

            $this->setDataProperty($data);

            return $this;
        }

        public function validateDataForInsert(array $data): ?self
        {
            return $this->sanitizeAndValidate($data, true);
        }

        public function validateData(array $data): ?self
        {
            return $this->sanitizeAndValidate($data, false);
        }

        public function validateProperty(string $property, mixed $value): ?self
        {
            $data = [
                $property => $value
            ];

            return $this->validateData($data);
        }

    }
