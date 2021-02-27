<?php
    declare(strict_types=1);

    require_once APPPATH . 'abstract/Validate.php';

    require_once APPPATH . 'interfaces/InterfaceValidate.php';
    require_once APPPATH . 'interfaces/InterfaceSet.php';
    require_once APPPATH . 'interfaces/InterfaceCrud.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Role_model extends Validate implements InterfaceValidate, InterfaceSet, InterfaceCrud
    {
        public int $id;
        public string $role;
        public string $active;
        public string $created;
        public string $updated;

        private string $table = 'roles';
        private array $data = [];

        protected function getThisTable(): string
        {
            return $this->table;
        }

        protected function setDataProperty(array $data): void
        {
            $this->data = $data;
            return;
        }

        protected function getDataProperty(): array
        {
            return $this->data;
        }

        protected function insertValidate(array $data): bool
        {
            if (!isset($data['role']) || !isset($data['active'])) return false;

            return $this->updateValidate($data);
        }

        protected function updateValidate(array $data): bool
        {
            if (!count($data)) return false;

            if (isset($data['role']) &&  !Validate_helper::validateString($data['role'], 2)) return false;

            if ( isset($data['active']) &&  !($data['active'] === '0' || $data['active'] === '1') ) return false;

            return true;
        }
    }
