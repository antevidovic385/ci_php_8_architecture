<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH . 'abstract/Read.php';

    Abstract Class Create extends Read
    {

        abstract protected function getThisTable(): string;

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        final public function create(): bool
        {
            $data = $this->getPublicPropertiesArray();

            if (!$data) return false;

            $this->db->insert($this->getThisTable(), $data);
            $this->id  = $this->db->insert_id();

            return $this->id > 0 ? true : false;
        }

        private function prepareMultipleArrayInsert(array $data): ?array
        {
            $insertData = array_map(function ($array) {
                return $this->validateData($array)?->setObject()?->getPublicPropertiesArray();
            }, $data);

            $insertData = array_filter($insertData, function($array) {
                return $array;
            });
 
            return ( count($data) === count($insertData) ) ? $insertData : null;
        }

        final public function multipleCreate(array $data) : bool
        {
            $insertData = $this->prepareMultipleArrayInsert($data);

            if (is_null($insertData)) return false;

            $insert = $this->db->insert_batch($this->getThisTable(), $insertData);

            return $insert ? true : false;
        }

        final public function insertOnDuplicateKeyUpdate(array $data): bool
        {
            $insertData = $this->prepareMultipleArrayInsert($data);

            if (is_null($insertData)) return false;

            $tableColumns = array_keys($insertData[0]);

            $query  = 'INSERT INTO ' . $this->getThisTable() . ' ';
            $query .= '(' . implode(',' , $tableColumns) . ') ';
            $query .= 'VALUES ';

            // prepare values
            $allValues = [];
            foreach($insertData as $array) {
                $rawValues = array_values($array);
                $escapeValues = array_map(function ($rawValue) {
                    return $this->db->escape($rawValue);
                }, $rawValues);
                array_push($allValues, '(' . implode(' , ', $escapeValues) . ') ');
            }
            $query .= implode(', ', $allValues);

            // prepare on update
            $onUpdate = [];
            foreach ($tableColumns as $column) {
                array_push($onUpdate, $column . ' = VALUES (' . $column . ')');
            }
            $query .= ' ON DUPLICATE KEY UPDATE ';
            $query .= implode(', ', $onUpdate);
            $query .= ';';

            return $this->db->query($query);
        }

        public function __destruct()
        {
            $this->unsetObject();
        }
    }
