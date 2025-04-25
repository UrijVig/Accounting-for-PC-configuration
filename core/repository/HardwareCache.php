<?php
    class HardwareCache{
        private $systemUnitsCache = [];
        private $monitorsCache = [];
        private $isActual = false;
        public function __construct(private DataSource $ds) {
        }

        public function loadCache() {
            if (!$this->isActual){
                $this->systemUnitsCache = $this->ds->getDataFromTable('system_units');
                $this->monitorsCache = $this->ds->getDataFromTable('monitors');
                $this->isActual = true;
            }
        }
        public function invalidate(){
            $this->isActual = false;
            $this->monitorsCache = [];
            $this->systemUnitsCache = [];
        }
        public function getSystemUnitsCache() {
            $this->loadCache();
            return $this->systemUnitsCache;
        }
        
        public function getMonitorsCache() {
            $this->loadCache();
            return $this->monitorsCache;
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