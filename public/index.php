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

    require_once 'DataBaseConnection.php';
    require_once 'DataSource.php';
    require_once 'dbfile.php';
    require_once 'HardwareCache.php';
    require_once 'HardwareRepository.php';
    require_once 'Monitor.php';
    require_once 'SystemUnit.php';
    require_once 'WorkPlace.php';

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