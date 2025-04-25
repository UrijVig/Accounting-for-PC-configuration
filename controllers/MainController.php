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

        public function actionCreateSystemUnit(){
            $this->title = "CreateUnit";
            $this->meta_desc = "Добавление системного блока";
            $this->meta_key = "создание";
            $content = $this->view->render("createSystemUnit", array(), true);
            $this->render($content);
        }
        public function actionCreateMonitor(){
            $this->title = "createMonitor";
            $this->meta_desc = "createMonitor";
            $this->meta_key = "createMonitor";
            $content = $this->view->render("createMonitor", array(), true);
            $this->render($content);
        }
        public function actionInfo() {
            $this->title = "Info";
            $this->meta_desc = "Описание позиций";
            $this->meta_key = "описание, описание позиций";
            
            $data = $this->mainService->getProducts();  // Переименовать метод в getProducts()
            $content = $this->view->render("info", [
                'system_units' => $data,
                'monitors' => $data
            ], true);
            $this->render($content);
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

        public function actionSystemUnit($method, $action){
            if ($method === "POST"){
                $fun = $action[0] . "SystemUnit";
                if (method_exists($this->mainService, $fun)){
                    $this->mainService->$fun();
                }
            }
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
    }