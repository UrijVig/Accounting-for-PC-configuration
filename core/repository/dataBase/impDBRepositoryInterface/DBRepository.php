<?php 
    class DBRepository implements DBRepositoryInterface{
        public function __construct(private DBInterface $ds) {}

        public function addRecord(string $tableName, array $data){
            try{
                $this->ds->create($tableName, $data);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        public function getRecordByTarget(string $tableName, string $target){
            return $this->ds->readByTarget($tableName, $target);
        }
        public function getAllRecord(string $tableName){
            return $this->ds->readAll($tableName);
        }
        public function removeRecordByTarget(string $tableName, string $target){
            try{
                $this->ds->deleteByTarget($tableName, $target);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        public function updateRecordByTarget(string $tableName , string $target, array $data){
            $this->ds->updateByTarget($tableName, $target, $data);
        }
    }