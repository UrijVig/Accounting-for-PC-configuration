<?php 
    class DataService{ 
        private DataBaseConnection $dbc;
        private DataSource $ds;
        private DBRepositoryInterface $dBRepository;
        private DBRepositoryManager $dBRepositoryManager;
        private CacheRepositoryInterface $cacheRepository;
        public function __construct(array $config) {
            $this->dbc = $this->connectDB($config);
            $this->ds = new DataSource($this->dbc);
            $this->dBRepository = new DBRepository($this->ds);
            $this->dBRepositoryManager = new DBRepositoryManager($this->dBRepository, $config['tables']);
            $this->cacheRepository = new CacheRepository($this->dBRepository,$config['tables']);
        }
        private function connectDB($config) {
            return new DataBaseConnection(
                $config['dsn'],
                DB_USER,
                DB_PASS,
                DB_OPTS
            );
        }
        
        public function getDataFromTable(array $tableNames):array {
            $data = [];
            foreach ($tableNames as $tableName){
                $data[$tableName] = $this->cacheRepository->getCache($tableName);
            }
            return $data;
        }

        public function getData():array {
            $data = $this->cacheRepository->getAll();
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
    // 'tables' => ['system_units', 'peripheries','ups','monitors','locations']

    }