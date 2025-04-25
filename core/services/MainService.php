<?php
    class MainService{

        private DataBaseConnection $dbc;
        private DataSource $ds;
        private HardwareRepository $repo;
        private HardwareCache $cache;
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
            $this->cache = $cache ?? new HardwareCache($this->ds);
            $this->repo = $repo ?? new HardwareRepository($this->dbc, $this->cache);
        }

        public function getProducts(): array {
            $systemUnits = $this->cache->getSystemUnitsCache();
            $monitors = $this->cache->getMonitorsCache();
            
            // Группируем мониторы по computer_name
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

        public function addSystemUnit(){
            echo "<pre>";
            print_r($_POST);
            echo "<pre>";
        }
        public function addMonitor(){
            echo "<pre>";
            print_r($_POST);
            echo "<pre>";
        }
    }