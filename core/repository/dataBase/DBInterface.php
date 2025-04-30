<?php 
    interface DBInterface{
        public function create(string $tableName, array $data);
        public function readAll(string $tableName);
        public function readByTarget(string $tableName, string $target);
        public function updateByTarget(string $tableName, string $column, string $target, array $data);
        public function deleteByTarget(string $tableName, string $column, string $target);
    }