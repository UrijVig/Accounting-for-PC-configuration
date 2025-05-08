<?php 
    interface CacheRepositoryInterface{
        public function loadAll();
        public function getAll();
        public function invalidateAll();
        public function loadCache(string $tableName);
        public function getCache(string $tableName);
        public function invalidateCache(string $tableName);
        public function getFromCacheByTarget(string $tableName, string $column, string $target);
    }