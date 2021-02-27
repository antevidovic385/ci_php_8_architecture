<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH . 'abstract/Create.php';

    Abstract Class Set extends Create
    {

        abstract protected function getDataProperty(): array;
        abstract protected function setDataProperty(array $data): void;
        abstract protected function getThisTable(): string;

        private function setPropertyValue(string $property, mixed $value): void
        {
            $type = new ReflectionProperty($this, $property);
            Utility_helper::setValue($type->getType()->getName(), $value);
            $this->{$property} = $value;

            return;
        }

        private function unsetPublicProperties(): void
        {
            $keys = $this->getPublicPropertiesNames();

            foreach ($keys as $key) {
                unset($this->{$key});
            }

            return;
        }

        public function unsetObject(): void
        {
            $this->unsetPublicProperties();
            $this->setDataProperty([]);

            return;
        }

        public function setObject(): ?self
        {
            $data = $this->getDataProperty();

            $this->unsetObject();

            foreach ($data as $property => $value) {
                $this->setPropertyValue($property, $value);
            }

            return $this;
        }

        public function setObjectId(int $value): self
        {
            $this->id = $value;
            return $this;
        }

        public function fetchAndSetObject(array $what = []): void
        {
            $fetch = empty($what) ? '*' : 'id,' . implode(',', $what);
            $data = $this->readImproved([
                'what' => [$fetch],
                'where' => $this->getWhereThisId()
            ]);

            if (is_null($data)) return;

            $this->unsetObject();

            $data = reset($data);

            foreach ($data as $property => $value) {
                $this->setPropertyValue($property, $value);
            }

            return;
        }

    }
