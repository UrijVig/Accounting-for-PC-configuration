<?php 
    class ReadController extends MainController{
        protected DataService $oficeDataService;
        protected DataService $storageDataService;
        public function __construct() {
            $this->oficeDataService = new DataService(OFFICE_CONFIG);
            $this->storageDataService = new DataService(STORAGE_CONFIG);
            parent::__construct();
        }
        public function actionOffice(string $method,array $param){
            $this->title = "Office";
            $this->meta_desc = "Оборудование офиса";
            $this->meta_key = "офис";            
            $data = $this->oficeDataService->getFormattedData();
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            $content = $this->view->render("office", ['locations' => $data], true);
            $this->render($content);
        }
        public function actionStorage(string $method,array $param){
            $this->title = "Storage";
            $this->meta_desc = "Оборудование на складе";
            $this->meta_key = "склад";             
            $data = $this->storageDataService->getFormattedData();
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            $content = $this->view->render("Storage", ['data' => $data], true);
            $this->render($content);
        }
    }