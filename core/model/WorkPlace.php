<?php

class WorkPlace{
    private $monitors = [];
    private SystemUnit $systemUnit;
    public function __construct(SystemUnit $systemUnit) {
        $this->systemUnit = $systemUnit;
    }            
    public function addMonitor(Monitor $monitor){
        $this->monitors[] = $monitor;
    }        
    public function getMonitors(){
        return $this->monitors;
    }
    public function getSystemUnits(){
        return $this->systemUnit;
    }
}
