<?php

use Dom\Document;

    class DataService{ 
        private DataBaseConnection $dbc;
        private DataSource $ds;
        private string $dbName;
        private DBRepositoryInterface $dBRepository;
        private DBRepositoryManager $dBRepositoryManager;
        private CacheRepositoryInterface $cacheRepository;
        public function __construct(array $config) {
            $this->dbc = $this->connectDB($config);
            $this->dbName = $config['dbname'];
            $this->ds = new DataSource($this->dbc);
            $this->dBRepository = new DBRepository($this->ds);
            $this->dBRepositoryManager = new DBRepositoryManager($this->dBRepository, $config['tables']);
            $this->cacheRepository = new CacheRepository($this->dBRepository,$config['tables']);
        }
        private function connectDB($config) {
            return new DataBaseConnection(
                $config['dsn'],
                DB_USER,
                DB_PASS,
                DB_OPTS
            );
        }
        
        public function getDataFromTables(array $tableNames):array {
            $data = [];
            foreach ($tableNames as $tableName){
                $data[$tableName] = $this->cacheRepository->getCache($tableName);
            }
            return $data;
        }
        public function getDataFromTableByTarget($tableName, $column, $target){
            return $this->cacheRepository->getFromCacheByTarget($tableName, $column, $target);
        }

        public function getFormattedData():array {
            $data = $this->cacheRepository->getAll();
            return DataDesigner::getDetails($data, $this->dbName);
        }

        public function deleteRecord(string $tablename,string $column,string $target) {
            $this->dBRepositoryManager->delegate($tablename, "removeRecordByTarget", $column,null, $target);
            $this->cacheRepository->invalidateCache($tablename);
        }
        public function updateRecord(string $tablename, array $data, string $column, string $target){
            $this->dBRepositoryManager->delegate($tablename, "updateRecordByTarget", $column, $data, $target);
            $this->cacheRepository->invalidateCache($tablename);
        }

    }