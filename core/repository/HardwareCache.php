<?php
    class HardwareCache{
        private $systemUnitsCache = [];
        private $monitorsCache = [];

        private $isActual = false;
        public function __construct(private HardwareRepository $hardwareRepository) {
        }

        public function invalidate(){
            $this->isActual = false;
            $this->monitorsCache = [];
            $this->systemUnitsCache = [];
        }

        public function getSystemUnitsCache() {
            return $this->systemUnitsCache;
        }
        
        public function getMonitorsCache() {
            return $this->monitorsCache;
        }
        public function setSystemUnitsCache($systemUnitsCache) {
            $this->systemUnitsCache = $systemUnitsCache;
        }
        
        public function setMonitorsCache($monitorsCache) {
            $this->monitorsCache = $monitorsCache;
        }
        public function setActual($mark = true){
            $this->isActual = $mark;
        }
        public function isActual(){
            return $this->isActual;
        }

        public function getSystemUnitBySerialNumber($serialNumber) {
            foreach ($this->systemUnitsCache as $systemUnitData) {
                if ($systemUnitData['serial_number'] === $serialNumber){
                    return $systemUnitData;
                }
            }
        }
        public function getMonitorByComputerName($computerName){
            $monitors = [];
            foreach ($this->monitorsCache as $monitorData){
                if($monitorData['computer_name'] === $computerName){
                    $monitors[] = $monitorData;
                }
            }
            return $monitors;
        }

    }