<?php
    class HardwareRepository{
        private HardwareCache $hardwareCache;

        public function __construct(private DataSource $ds) {
            $this->hardwareCache = new HardwareCache($this);
        }

        public function loadCache(){
            if (!$this->hardwareCache->isActual()){
                $this->hardwareCache->setSystemUnitsCache($this->getSystemUnitsdata());
                $this->hardwareCache->setMonitorsCache($this->getMonitorsData());
                $this->hardwareCache->setActual();
            }
        }

        public function getSystemUnitsdata(){
            return $this->ds->getDataFromTable('system_units');
        }
        public function getMonitorsData(){
            return $this->ds->getDataFromTable('monitors');
        }
        public function invalidateCache(){
            $this->hardwareCache->invalidate();
        }
        public function getSystemUnitsCache(){
            $this->loadCache();
            return $this->hardwareCache->getSystemUnitsCache();
        }
        public function getMonitorsCache(){
            $this->loadCache();
            return $this->hardwareCache->getMonitorsCache();
        }
        public function addPosition(string $tableName, $data){
            try{
                $this->ds->inputDataInTable($tableName, $data);
            } catch (PDOException $e) {
                throw new PDOException($e);
            }
        }

        public function getWorkPlaceBySerialNumber($serialNumber): WorkPlace{
            $systemUnitData = $this->hardwareCache->getSystemUnitBySerialNumber($serialNumber);
            if (!$systemUnitData){
                throw new Exception("Данный серийный номер $serialNumber не найден!");
            }
            $systemUnit = new SystemUnit(...$systemUnitData);
            $workPlace = new WorkPlace($systemUnit);
            $monitorsData = $this->hardwareCache->getMonitorByComputerName($systemUnitData['computer_name']);
            foreach ($monitorsData as $monitor) {
                $workPlace->addMonitor(new Monitor(...$monitor));
            }
            return $workPlace;
        }  
    }