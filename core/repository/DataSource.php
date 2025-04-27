<?php
    class DataSource{
        public function __construct(private DataBaseConnection $dbc) {
        }
        public function getDataFromTable($tableName){
            return $this->dbc->getPDO()->query("SELECT * FROM $tableName")->fetchAll();
        }
        public function inputDataInTable($tableName, $data){
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
                throw new PDOException($e);
            }
            
        }
    }