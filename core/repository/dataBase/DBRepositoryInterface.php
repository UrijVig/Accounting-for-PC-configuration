<?php 
    interface DBRepositoryInterface{
        public function addRecord(string $tableName, array $data);
        public function getRecordByTarget(string $tableName, string $target);
        public function getAllRecord(string $tableName);
        public function removeRecordByTarget(string $tableName, string $target);
        public function updateRecordByTarget(string $tableName , string $target, array $data);

    }