<?php 
    class DataCache implements DataCacheInterface{
        private bool $isActual = false;
        private $tableName;
        private $cache = [];

        public function __construct(string $tableName) {
            $this->tableName = $tableName;
        }

        public function invalidate(){
            $this->isActual = false;
            $this->cache = [];
        }
        public function getCache(){
            return $this->cache;
        }
        public function getFromCacheByTarget(string $target){
            foreach ($this->cache as $row){
                if (in_array($target, $row)) return $row;
            } throw new InvalidArgumentException("Invalid Target");            
        }

        public function loadCache(array $data){
            $this->isActual = true;
            $this->cache = $data;
        }

        public function setActual($mark = false){
            $this->isActual = $mark;
        }
        public function isActual(){
            return $this->isActual;
        }

        public function getTableName():string{
            return $this->tableName;
        }
    }