<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH . 'abstract/Getters.php';

    Abstract Class Getters extends CI_Model
    {

        abstract protected function getThisTable(): string;

        protected function getPublicPropertiesNames(): array
        {
            $reflect = new ReflectionClass($this);
            $publics = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
            $publicProperties = array_map(function($el) {
                return $el->name;
            }, $publics);

            return $publicProperties;
        }

        protected function getPublicPropertiesArray(): ?array
        {
            $data = get_object_vars($this);

            if (isset($data['id'])) unset($data['id']);

            return $data ? $data : null;
        }

        protected function getWhereThisId(): array
        {
            return [
                $this->getThisTable() . '.id = ' => $this->id
            ];
        }

    }
