<?php
    class DataSource implements DBInterface{
        public function __construct(private DataBaseConnection $dbc) {
        }
        public function create(string $tableName, array $data){
            try {
                $columns = implode(', ', array_keys($data));
                $placeholders = ':' . implode(', :', array_keys($data));
                $stmt = $this->dbc->getPDO()->prepare("INSERT INTO $tableName ($columns) VALUES ($placeholders)");

                foreach ($data as $key=>$val) {
                    $paramsType = match (true) {
                        is_int($val) => PDO::PARAM_INT,
                        is_float($val) => PDO::PARAM_STR,
                        default => PDO::PARAM_STR                        
                    };
                    $stmt->bindValue(":$key", $val, $paramsType);
                }
                return $stmt->execute();
            } catch (PDOException $e) {
                throw $e;
            }
        }
        public function readAll(string $tableName):array{
            return $this->dbc->getPDO()->query("SELECT * FROM $tableName")->fetchAll();

        }
        public function readByTarget(string $tableName, string $target){
            try {
                $stmt = $this->dbc->getPDO()->prepare("SELECT * from `$tableName` WHERE serial_number = :serial_number");
                $stmt->bindValue(":serial_number", $target, PDO::PARAM_STR);
                return $stmt->execute();
            } catch (PDOException $e) {
                throw $e;
            }
        }

        
        public function updateByTarget(string $tableName , string $target, array $data){
            try {
                $updates =[];
                foreach ($data as $key => $val) {
                    $updates [] = "`$key` = :$key";
                }
                $stmt = $this->dbc->getPDO()->
                    prepare("UPDATE `$tableName` SET " . implode(', ', $updates) . "WHERE serial_number = :serial_number");
                foreach ($data as $key=>$val) {
                    $paramsType = match (true) {
                        is_int($val) => PDO::PARAM_INT,
                        is_float($val) => PDO::PARAM_STR,
                        default => PDO::PARAM_STR                        
                    };
                    $stmt->bindValue(":$key", $val, $paramsType);
                    return $stmt->execute();
                }
            } catch (PDOException $e) {
                throw $e;
            }
        }
        public function deleteByTarget(string $tableName, string $target){
            try {
                $stmt = $this->dbc->getPDO()->prepare("DELETE FROM `$tableName` WHERE serial_number = :serial_number");
                $stmt->bindValue(":serial_number", $target, PDO::PARAM_STR);
                return $stmt->execute();
            } catch (PDOException $e) {
                throw $e;
            }
        }    

    }