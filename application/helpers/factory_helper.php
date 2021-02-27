<?php
    declare(strict_types=1);

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Factory_helper
    {
        private static function getModel(string $model): object
        {
            $CI =& get_instance();
            $CI->load->model($model);
            return $CI->{$model};
        }

        public static function callCustomFunction(string $model, string $function, array $arguments): mixed
        {
            $object = self::getModel($model);

            return call_user_func_array([$object, $function], [...$arguments]);
        }

        // public static function callCustomFunctionImproved(string $model, int $id, string $function, array $arguments): mixed
        // {
        //     $object = self::callCustomFunction($model, 'setObjectId', [$id]);

        //     return call_user_func_array([$object, $function], [...$arguments]);
        // }

        public static function create(string $model, array $data): null|int
        {
            $object = self::getModel($model);

            if (!$object->validateDataForInsert($data)?->setObject()?->create()) return null;

            $id = $object->id;
            $object->unsetObject();

            return $id;
        }

        public static function multipleCreate(string $model, array $data): bool
        {
            return self::callCustomFunction($model, __FUNCTION__, [$data]);
        }

        public static function insertOnDuplicateKeyUpdate(string $model, array $data): bool
        {
            return self::callCustomFunction($model, __FUNCTION__, [$data]);
        }

        public static function readImproved(string $model, array $filter): ?array
        {
            return self::callCustomFunction($model, __FUNCTION__, [$filter]);
        }

        public static function getProperty(string $model, int $id, string $property): null|string|int|float
        {
            $object = self::getModel($model);
            $object->setObjectId($id);

            return $object->getProperty($property);
        }

        public static function update(string $model, array $what, int|array $where): bool
        {
            $object = self::getModel($model);
            if (is_int($where)) {
                return $object->validateData($what)?->setObject()?->setObjectId($where)?->update();
            }
            return $object->validateData($what)?->setObject()?->customUpdate($where);
        }

        public static function fetchAndSet(string $model, int $id, array $what = []): null|object
        {
            $object = self::getModel($model);
            $object->setObjectId($id);
            $object->fetchAndSetObject($what);

            if (empty($object->id)) return null;

            $return = clone $object;
            $object->unsetObject();

            return $return;
        }

        public static function delete(string $model, int|array $where): bool
        {
            $object = self::getModel($model);

            return is_int($where) ? $object->setObjectId($where)->delete() : $object->customDelete($where);
        }

    }
