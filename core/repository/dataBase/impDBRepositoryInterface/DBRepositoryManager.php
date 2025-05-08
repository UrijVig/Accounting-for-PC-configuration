<?php 
    class DBRepositoryManager{
        public function __construct(private DBRepositoryInterface $dBRepository, private array $listOfTables) {}

        public function delegate(string $tablename, string $operation, string $column = null, array $data = null, string $target = null){
            if (!in_array($tablename, $this->listOfTables)){
                throw new InvalidArgumentException("Table $tablename does not exist");
            }
            return match($operation){
                'addRecord' => $this->dBRepository->addRecord($tablename, $data),
                'getAllRecord' => $this->dBRepository->getAllRecord($tablename),
                'getRecordByTarget' => $this->dBRepository->getRecordByTarget($tablename, $target),
                'removeRecordByTarget' => $this->dBRepository->removeRecordByTarget($tablename,  $column, $target),
                'updateRecordByTarget' => $this->dBRepository->updateRecordByTarget($tablename, $column, $target , $data),
                default => throw new InvalidArgumentException("Invalid operation")                
            };
        }
    }