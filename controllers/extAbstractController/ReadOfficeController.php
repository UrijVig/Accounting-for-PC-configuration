<?php 
    class ReadOfficeController extends MainController{
        protected DataService $oficeDataService;
        public function __construct() {
            $this->oficeDataService = new DataService(OFFICE_CONFIG);
            parent::__construct();
        }
        public function actionOfficeInfo(){
            $this->title = "OfficeMap";
            $this->meta_desc = "Карта офиса";
            $this->meta_key = "офис";            
            $data = $this->oficeDataService->getData();
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            $content = $this->view->render("officeInfo", ['locations' => $data], true);
            $this->render($content);
        }
    }