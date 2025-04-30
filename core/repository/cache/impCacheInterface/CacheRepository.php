<?php 
 class CacheRepository implements CacheRepositoryInterface{
    private $repository = [];
    public function __construct(private DBRepository $dBRepository,array $listOfTables) {
        foreach ($listOfTables as $table) {
            $this->repository[$table] = new DataCache( $table);
        }
    }
    public function loadAll(){
        foreach ($this->repository as  $key => $value) {
            if (!$value->isActual())
                $value->loadCache($this->dBRepository->getAllRecord($value->getTableName()));
        }
    }
    public function getAll(){
        $this->loadAll();
        $cacheData = [];
        foreach ($this->repository as $key => $value) {
            $cacheData[$value->getTableName()] = $value->getCache();
        } return $cacheData;
    }
    public function invalidateAll(){
        foreach ($this->repository as $key => $value) {
            $value->invalidate();
        }
    }
    public function loadCache(string $tableName){
        if (!$this->repository[$tableName]->isActual())
        $this->repository[$tableName]->loadCache($this->dBRepository->getAllRecord($tableName));
    }
    public function getCache(string $tableName){
        $this->loadCache($tableName);
        return $this->repository[$tableName]->getCache();
    }
    public function invalidateCache(string $tableName){
        $this->repository[$tableName]->invalidate();
    }
    public function getFromCacheByTarget(string $tableName, string $target){
        return $this->repository[$tableName]->getFromCacheByTarget($target);
    }
    
 }