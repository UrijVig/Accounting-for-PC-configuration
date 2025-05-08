<?php
    interface DataCacheInterface{
        public function invalidate();
        public function getCache();
        public function loadCache(array $data);
        public function getFromCacheByTarget( string $column, string $target);
    }