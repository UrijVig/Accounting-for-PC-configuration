<?php 
    class DBRepositoryManager{
        public function __construct(private DBRepositoryInterface $dBRepository, private array $listOfTables) {}

        public function delegate(string $position, string $operation, string $column = null, array $data = null, string $target = null){
            if (!in_array($position, $this->listOfTables)){
                throw new InvalidArgumentException("Table $position does not exist");
            }
            return match($operation){
                'addRecord' => $this->dBRepository->addRecord($position, $data),
                'getAllRecord' => $this->dBRepository->getAllRecord($position),
                'getRecordByTarget' => $this->dBRepository->getRecordByTarget($position, $target),
                'removeRecordByTarget' => $this->dBRepository->removeRecordByTarget($position,  $column, $target),
                'updateRecordByTarget' => $this->dBRepository->updateRecordByTarget($position, $column, $target , $data),
                default => throw new InvalidArgumentException("Invalid operation")                
            };
        }
    }