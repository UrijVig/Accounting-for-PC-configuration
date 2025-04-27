<?php
    class MainService{

        private DataBaseConnection $dbc;
        private DataSource $ds;
        private HardwareRepository $repo;

        public function __construct(
            ?DataBaseConnection $dbc = null,
            ?DataSource $ds = null,
            ?HardwareCache $cache = null,
            ?HardwareRepository $repo = null
        ) {
            // Dependency Injection с возможностью создания по умолчанию
            $this->dbc = $dbc ?? new DataBaseConnection(
                DBConf::getDsn(),
                DBConf::$user,
                DBConf::$pass,
                DBConf::getOpts()
            );
            
            $this->ds = $ds ?? new DataSource($this->dbc);
            $this->repo = $repo ?? new HardwareRepository($this->ds);
        }

        public function getProducts(): array {
            $systemUnits = $this->repo->getSystemUnitsCache();
            $monitors = $this->repo->getMonitorsCache();

            $monitorsByComputer = [];
            foreach ($monitors as $monitor) {
                $monitorsByComputer[$monitor['computer_name']][] = $monitor;
            }
            
            $result = [];
            foreach ($systemUnits as $unit) {
                $unit['monitors'] = $monitorsByComputer[$unit['computer_name']] ?? [];
                $result[] = $unit;
            }
            
            return $result;
        }

        public function addSystemUnit($data){
            try {
                $this->repo->addPosition("system_units", $data);
            } catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
        public function addMonitor($data){
            try {
                return $this->repo->addPosition("monitors", $data);
            } catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
    }