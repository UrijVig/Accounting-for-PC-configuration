<?php 
    class DataDesigner{
        static public function getDetails(array $data, string $dbname){
            if($dbname === OFFICE){
                return self::getOfficeDetails($data);
            } elseif ($dbname === STORAGE){
                return self::getStorageDetails($data);
            }
        }
        static private function getOfficeDetails(array $data):array {
            $monitorByComputer = [];
            $upsByComputer = [];
            $peripheriesByComputer =[];
            foreach ($data['monitors'] as $monitor){
                $monitorByComputer[$monitor['computer_name']][] = $monitor;
            }
            foreach ($data['ups'] as $ups) {
                $upsByComputer[$ups['computer_name']] = $ups;
            }
            foreach ($data['peripheries'] as $peripherie) {
                $peripheriesByComputer[$peripherie['computer_name']] = $peripherie;
            }
            $workplaces = [];
            foreach($data['system_units'] as $unit){
                $unit['monitors'] = $monitorByComputer[$unit['computer_name']] ?? [];
                $unit['ups'] = $upsByComputer[$unit['computer_name']] ?? [];
                $unit['peripheries'] = $peripheriesByComputer[$unit['computer_name']] ?? [];
                $workplaces[] = $unit;
            }
            $workplaceByLocationName = [];
            foreach ($workplaces as $wp) {
                $workplaceByLocationName[$wp['location']][] = $wp;
            }
            $result = [];
            foreach ($data['locations'] as $loc) {
                $loc['workplaces'] = $workplaceByLocationName[$loc['name']];
                $result[] = $loc;
            }
            return $result;
        }

        static private function getStorageDetails(array $data):array {
            $result = $data;
            return $result;
        }

    }