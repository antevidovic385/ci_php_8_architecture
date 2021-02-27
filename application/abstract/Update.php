<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH . 'abstract/Delete.php';

    Abstract Class Update extends Delete
    {

        abstract protected function getThisTable(): string;

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        final public function update(): bool
        {
            $where = $this->getWhereThisId();

            return $this->customUpdate($where);
        }

        final public function customUpdate(array $where): bool
        {
            $data = $this->getPublicPropertiesArray();

            if (!$data) return false;

            $this->db->update($this->getThisTable(), $data, $where);

            $affectedRows = $this->db->affected_rows();

            return $affectedRows > 0 ? true : false;
        }

        public function __destruct()
        {
            $this->unsetObject();
        }

    }
