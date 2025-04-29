<?php
    class Monitor{
        private $serialNumber;
        private $model;
        private $diagonal;
        private $computerName; // Ссылка на системный блок

        public function __construct(
            string $serial_number,
            string $model,
            float $diagonal,
            string $computer_name
        ) {
            $this->serialNumber = $serial_number;
            $this->model = $model;
            $this->diagonal = $diagonal;
            $this->computerName = $computer_name;
        }
        public function getSerialNumber(){
            return $this->serialNumber;
        }
        public function getModel(){
            return $this->model;
        }
        public function getDiagonal(){
            return $this->diagonal;
        }
        public function getComputerName(){
            return $this->computerName;
        }

    }