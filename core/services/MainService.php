<?php
    class MainService{

        private DataBaseConnection $dbc;
        private DataSource $ds;
        private DBRepositoryInterface $dBRepository;
        private DBRepositoryManager $dBRepositoryManager;
        private CacheRepositoryInterface $cacheRepository;
        public function __construct() {
            // Dependency Injection с возможностью создания по умолчанию
            $this->dbc = $dbc ?? new DataBaseConnection(
                DB_DSN,
                DB_USER,
                DB_PASS,
                DB_OPTS
            );            
            $this->ds = $ds ?? new DataSource($this->dbc);
            $this->dBRepository = new DBRepository($this->ds);
            $this->dBRepositoryManager = new DBRepositoryManager($this->dBRepository);
            $this->cacheRepository = new CacheRepository($this->dBRepository);
        }

        public function getProducts(): array {
            $systemUnits = $this->cacheRepository->getCache("system_units");
            $monitors = $this->cacheRepository->getCache("monitors");

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
        public function getProduct($serialNumber): array {
            return $this->cacheRepository->getFromCacheByTarget("system_units", $serialNumber);            
        }

        public function addSystemUnit($data){
            try {
                return $this->dBRepositoryManager->delegate('system_units', 'addRecord', $data);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        public function addMonitor($data){
            try {
                return $this->dBRepositoryManager->delegate('monitors', 'addRecord', $data);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        public function updateSystemUnit($data){
            try {
                return $this->dBRepositoryManager->delegate('system_units', 'updateRecordByTarget', $data, $data['serial_number']);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        public function updateMonitor($data){
            try {
                return $this->dBRepositoryManager->delegate('monitors', 'updateRecordByTarget', $data, $data['serial_number']);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        public function deleteSystemUnit(string $serialNumber){
            try {
                return $this->dBRepositoryManager->delegate('system_units', 'removeRecordByTarget', array(),$serialNumber );
            } catch (PDOException $e) {
                throw $e;
            }
        }
        public function deleteMonitor(string $serialNumber){
            try {
                return $this->dBRepositoryManager->delegate('monitors', 'removeRecordByTarget', array(), $serialNumber);
            } catch (PDOException $e) {
                throw $e;
            }
        }
    }