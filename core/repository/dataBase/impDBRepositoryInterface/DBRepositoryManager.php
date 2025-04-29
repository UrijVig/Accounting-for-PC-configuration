<?php 
    class DBRepositoryManager{
        public function __construct(private DBRepositoryInterface $dBRepository) {}

        public function delegate(string $position, string $operation, array $data = null, string $target = null){
            if (!in_array($position, DB_TABLE_NAMES)){
                throw new InvalidArgumentException("Table $position does not exist");
            }
            return match($operation){
                'addRecord' => $this->dBRepository->addRecord($position, $data),
                'getAllRecord' => $this->dBRepository->getAllRecord($position),
                'getRecordByTarget' => $this->dBRepository->getRecordByTarget($position, $target),
                'removeRecordByTarget' => $this->dBRepository->removeRecordByTarget($position, $target),
                'updateRecordByTarget' => $this->dBRepository->updateRecordByTarget($position, $target , $data),
                default => throw new InvalidArgumentException("Invalid operation")                
            };
        }
    }