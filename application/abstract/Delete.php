<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH . 'abstract/Getters.php';

    Abstract Class Delete extends Getters
    {

        abstract protected function getThisTable(): string;

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        final public function delete(): bool
        {
            $where = $this->getWhereThisId();

            return $this->customDelete($where);
        }

        final public function customDelete(array $where): bool
        {
            $this->db->delete($this->getThisTable(), $where);

            return $this->db->affected_rows() ? true : false;
        }

    }
