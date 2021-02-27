<?php
    declare(strict_types=1);

    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    Interface InterfaceCrud
    {
        public function create(): bool;
        public function multipleCreate(array $data) : bool;
        public function insertOnDuplicateKeyUpdate(array $data): bool;
        public function readImproved(array $filter): ?array;
        public function getProperty(string $property): null|string|int|float;
        public function update(): bool;
        public function customUpdate(array $where): bool;
        public function delete(): bool;
        public function customDelete(array $where): bool;
    }
