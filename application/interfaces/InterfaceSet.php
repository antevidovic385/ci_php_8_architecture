<?php
    declare(strict_types=1);

    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    Interface InterfaceSet
    {
        public function unsetObject(): void;
        public function setObject(): ?object;
        public function setObjectId(int $value): object;
        public function fetchAndSetObject(array $what = []): void;
    }
