<?php
    class HardwareRepository{

        public function __construct(private DataBaseConnection $dbc, private HardwareCache $hardwareCache) {
        }

        public function loadCache(){
            $this->hardwareCache->invalidate();
            $this->hardwareCache->loadCache();
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