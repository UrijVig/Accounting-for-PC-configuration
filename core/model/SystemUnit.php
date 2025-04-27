<?php
    class SystemUnit{
        private $serialNumber;
        private $computerName;
        private $cpu;
        private $ram;
        private $diskSize;
        private $diskFree;
        private $gpu;
        private $location;
        private $description;

        public function __construct(
            string $serial_number = '',
            string $computer_name = '',
            string $cpu = '',
            int $ram_gb = 0,
            float $disk_size = 0,
            float $disk_free = 0,
            string $gpu = '',
            string $location = '',
            string $description = ''
        ) {
            $this->serialNumber = $serial_number;
            $this->computerName = $computer_name;
            $this->cpu = $cpu;
            $this->ram = $ram_gb;
            $this->diskSize = $disk_size;
            $this->diskFree = $disk_free;
            $this->gpu = $gpu;
            $this->location = $location;
            $this->description = $description;
        }
        public function getserialNumber(){
            return $this->serialNumber;
        }
        public function getComputerName(){
            return $this->computerName;
        }
        public function getCpu(){
            return $this->cpu;
        }
        public function getRam(){
            return $this->ram;
        }
        public function getDiskSize(){
            return $this->diskSize;
        }
        public function getDiskFree(){
            return $this->diskFree;
        }
        public function getGpu(){
            return $this->gpu;
        }
        public function getLocation(){
            return $this->location;
        }
        public function getDescription(){
            return $this->description;
        }

    }  