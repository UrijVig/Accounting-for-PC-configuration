<?php 
    class MainController extends AbstractController{
        protected $title;
        protected $meta_desc;
        protected $meta_key;
        protected MainService $mainService;

        public function __construct() {
            parent::__construct(new View(DIR_TMPL));
            $this->mainService = new MainService();
        }

        public function actionIndex(){
            $this->title = "Index";
            $this->meta_desc = "Описание главной страницы";
            $this->meta_key = "описание, описание главной страницы";
            $content = $this->view->render("index", array(), true);
            $this->render($content);
        }

        public function actionCreateSystemUnit($method, $action){
            if ($method === "POST"){                
                $valideData = $this->validateData();
                if ($valideData['errors']){
                    $this->title = "CreateUnit";
                    $this->meta_desc = "Добавление системного блока";
                    $this->meta_key = "создание";
                    $content = $this->view->render("createSystemUnit", ['data' => $valideData['data'], 'errors' => $valideData['errors']], true);
                    $this->render($content);
                }else{
                    try {
                        $this->mainService->addSystemUnit($valideData['data']);
                        header('Location: /info');
                        exit;
                    } catch (PDOException $e) {
                        $this->title = "CreateUnit - Error";
                        $content = $this->view->render("createSystemUnit", [
                        'data' => $valideData['data'],
                        'errors' => ['Ошибка сохранения в базу данных' . $e->getMessage()]
                        ], true);
                        $this->render($content);
                    }
                }
            } else{
                $this->title = "CreateUnit";
                $this->meta_desc = "Добавление системного блока";
                $this->meta_key = "создание";
                $content = $this->view->render("createSystemUnit", array(), true);
                $this->render($content);
            }
            
        }
        public function actionCreateMonitor($method, $action){
            if ($method === "POST"){                
                $valideData = $this->validateData();
                if ($valideData['errors']){
                    $this->title = "createMonitor";
                    $this->meta_desc = "createMonitor";
                    $this->meta_key = "createMonitor";
                    $content = $this->view->render("createMonitor", ['data' => $valideData['data'], 'errors' => $valideData['errors']], true);
                    $this->render($content);
                } else {
                    try {
                        $this->mainService->addMonitor($valideData['data']);
                        header('Location: /info');
                        exit;
                    } catch (PDOException $e) {
                        $this->title = "CreateMonitor - Error";
                        $content = $this->view->render("createMonitor", [
                        'data' => $valideData['data'],
                        'errors' => ['Ошибка сохранения в базу данных' . $e->getMessage()]
                        ], true);
                        $this->render($content);
                    }
                }
            } else{
                $this->title = "createMonitor";
                $this->meta_desc = "createMonitor";
                $this->meta_key = "createMonitor";
                $content = $this->view->render("createMonitor", array(), true);
                $this->render($content);
            }
        }
        public function actionInfo($method) {
            if (isset($_POST['delete']) && isset($_POST['serial_number'])){
                try {
                    switch ($_POST['delete']) {
                        case 'system_units':
                            $this->mainService->deleteSystemUnit($_POST['serial_number']);
                            break;
                        case 'monitor':
                            $this->mainService->deleteMonitor($_POST['serial_number']);
                            break;                    
                        default:
                            echo "Что-то пошло не так!";
                            break;
                    }
                    header('Location: /info');
                    exit;
                } catch (PDOException $e) {
                    echo "Ошибка при удалении позиции!" . $e->getMessage();
                }
            } else{
                $this->title = "Info";
                $this->meta_desc = "Описание позиций";
                $this->meta_key = "описание, описание позиций";            
                $data = $this->mainService->getProducts();
                $content = $this->view->render("info", ['system_units' => $data], true);
                $this->render($content);
            }
        }

        public function action404(){
            parent::action404();
            $this->title = "Page not found - 404";
            $this->meta_desc = "Page is not exist";
            $this->meta_key = "error 404";
            $content = $this->view->render("404", array(), true);
            $this->render($content);
        }
        public function action500(){
            parent::action404();
            $this->title = "500";
            $this->meta_desc = "500";
            $this->meta_key = "500";
            $content = $this->view->render("500", array(), true);
            $this->render($content);
        }
        public function actionMonitor($method, $action){
            if ($method === "POST"){
                $fun = $action[0] . "Monitor";
                if (method_exists($this->mainService, $fun)){
                    $this->mainService->$fun();
                }
            }
        }

        protected function getHeader(){
            $params = [];
            $params["title"] = $this->title;
            $params["meta_desc"] = $this->meta_desc;
            $params["meta_key"] = $this->meta_key;
            return $this->view->render("header", $params, true);
        }
        protected function getFooter(){
            return $this->view->render("footer", array(), true);
        }
        protected function render($val)
        {            
            $params = [];
            $params["header"] = $this->getHeader();
            $params["footer"] = $this->getFooter();
            $params["content"] = $val;
            $this->view->render(MAIN_LAYOUT, $params);
        }

        protected function validateData(){
            $errors = [];
            $data = [];
            foreach ($_POST as $key=>$val) {
                $data[$key] = trim($val) ?? '';
            }
            foreach ($data as $key => $val) {
                if ($val === '') $errors[] = "$key is empty!";                           
            }
            return [
                'data' => $data,
                'errors' => $errors
            ];
        }
    }