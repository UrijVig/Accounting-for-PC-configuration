<?php
    class DataSource{
        public function __construct(private DataBaseConnection $dbc) {
        }
        public function getDataFromTable($tableName){
            return $this->dbc->getPDO()->query("SELECT * FROM $tableName")->fetchAll();
        }
    }