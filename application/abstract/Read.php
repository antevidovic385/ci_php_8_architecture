<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH . 'abstract/Update.php';

    Abstract Class Read extends Update
    {

        abstract protected function getThisTable(): string;

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        final public function readImproved(array $filter): ?array
        {
            $this->db->select(implode(',', $filter['what']));

            $this->setJoins($this->db, $filter);
            $this->setFilterWhere($this->db, $filter);
            $this->setFilterWhereIn($this->db, $filter);
            $this->setFilterWhereNotIn($this->db, $filter);
            $this->setConditions($this->db, $filter);

            $result = $this->db->get($this->getThisTable())->result_array();

			return $result ? $result : null;
        }

        private function setJoins(object &$db, array $filter): void
        {
            if (empty($filter['joins']) )  return;

            $joins = $filter['joins'];
            foreach ($joins as $join) {
                $db->join(...$join);
            }

            return;
        }

        private function setFilterWhere(object &$db, array $filter): void
        {
            if (empty($filter['where'])) return;

            $db->where($filter['where']);

            return;
        }

        private function setFilterWhereIn(object &$db, array $filter): void
        {
            if (empty($filter['whereIn'])) return;

            $whereIn = $filter['whereIn'];
            $db->where_in($whereIn['column'], $whereIn['array']);

            return;
        }

        private function setFilterWhereNotIn(object &$db, $filter): void
        {
            if (empty($filter['whereNotIn'])) return;

            $whereNotIn = $filter['whereNotIn'];
            $this->db->where_not_in($whereNotIn['column'], $whereNotIn['array']);

            return;
        }

        private function setConditions($db, $filter): void
        {
            if (empty($filter['conditions'])) return;

            $conditions = $filter['conditions'];
            foreach ($conditions as $order => $arguments) {
                $db->$order(...$arguments);
            }

            return;
        }

        final public function getProperty(string $property): null|string|int|float
        {
            $result = $this->readImproved([
                'what'  => [$property],
                'where' => [
                    'id' => $this->id,
                ]
            ]);

            if (!empty($result)) {
                $value = $result[0][$property];
                $type = new ReflectionProperty($this, $property);
                Utility_helper::setValue($type->getType()->getName(), $value);
                return $value;
            }

            return null;
        }

    }
