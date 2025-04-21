<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    ini_set('display_errors', 1);
    ini_set('display_setup_errors', 1);
    error_reporting(E_ALL);

    $host = 'localhost';
    $db = 'pcdb';
    $user = 'admin';
    $pass = 'adminpass';
    $chrs = 'utf8mb4';
    $attr = "mysql:host=$host;dbname=$db;charset=$chrs";
    $opts = 
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    class DataBaseConnection{
        private $pdo;

        public function __construct($attr, $user, $password, $opts) {
            try {
                $this->pdo = new PDO($attr, $user, $password, $opts);
                echo "Подключение к базе данных успешно!";
            } catch (PDOException $e) {
                echo "Ошибка при попытке подключения к базе данных" . $e->getMessage();
            }
        }
        public function getPDO(){
            return $this->pdo;
        }
    }

    class DataSource{
        public function __construct(private DataBaseConnection $dbc) {
        }
        public function getDataFromTable($tableName){
            return $this->dbc->getPDO()->query("SELECT * FROM $tableName")->fetchAll();
        }
    }

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
            return $this->systemUnitsCache;
        }
        
        public function getMonitorsCache() {
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

    class Monitor{
        private $serialNumber;
        private $model;
        private $diagonal;
        private $computerName; // Ссылка на системный блок

        public function __construct(
            string $serial_number,
            string $model,
            float $diagonal,
            string $computer_name
        ) {
            $this->serialNumber = $serial_number;
            $this->model = $model;
            $this->diagonal = $diagonal;
            $this->computerName = $computer_name;
        }
        public function getSerialNumber(){
            return $this->serialNumber;
        }
        public function getModel(){
            return $this->model;
        }
        public function getDiagonal(){
            return $this->diagonal;
        }
        public function getComputerName(){
            return $this->computerName;
        }

    }

    class SystemUnit{
        private $serialNumber;
        private $computerName;
        private $cpu;
        private $ram;
        private $diskSize;
        private $diskFree;
        private $gpu;
        private $location;
        private $description;

        public function __construct(
            string $serial_number,
            string $computer_name,
            string $cpu,
            int $ram_gb,
            float $disk_size,
            float $disk_free,
            string $gpu,
            string $location,
            string $description
        ) {
            $this->serialNumber = $serial_number;
            $this->computerName = $computer_name;
            $this->cpu = $cpu;
            $this->ram = $ram_gb;
            $this->diskSize = $disk_size;
            $this->diskFree = $disk_free;
            $this->gpu = $gpu;
            $this->location = $location;
            $this->description = $description;
        }
        public function getserialNumber(){
            return $this->serialNumber;
        }
        public function getComputerName(){
            return $this->computerName;
        }
        public function getCpu(){
            return $this->cpu;
        }
        public function getRam(){
            return $this->ram;
        }
        public function getDiskSize(){
            return $this->diskSize;
        }
        public function getDiskFree(){
            return $this->diskFree;
        }
        public function getGpu(){
            return $this->gpu;
        }
        public function getLocation(){
            return $this->location;
        }
        public function getDescription(){
            return $this->description;
        }

    }  

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

    $systemUnits = [];
    $monitors = [];
    try {
        $dbc = new DataBaseConnection($attr, $user, $pass, $opts);
        $ds = new DataSource($dbc);
        $cache = new HardwareCache($ds);
        $repo = new HardwareRepository($dbc, $cache);

        $cache->loadCache();
        $systemUnits = $cache->getSystemUnitsCache();
        echo '<pre>';
        print_r($systemUnits);
        echo '</pre>';



    } catch(Exception $e){
        echo "<div style='color:red'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }

    ?>    
    
</body>
</html>