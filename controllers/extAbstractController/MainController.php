<?php 
    class MainController extends AbstractController{
        protected $title;
        protected $meta_desc;
        protected $meta_key;
        public function __construct() {
            parent::__construct(new View(DIR_TMPL));
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
            parent::action500();
            $this->title = "Internal Server Error - 500";
            $this->meta_desc = "Internal Server Error";
            $this->meta_key = "error 500";
            $content = $this->view->render("500", array(), true);
            $this->render($content);
        }
        public function actionIndex(){
            $this->title = "Index";
            $this->meta_desc = "Описание главной страницы";
            $this->meta_key = "описание, описание главной страницы";
            $content = $this->view->render("index", array(), true);
            $this->render($content);
        }
        public function actionPersonalPage(){

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
        protected function render($val){
            $params = [];
            $params["header"] = $this->getHeader();
            $params["footer"] = $this->getFooter();
            $params["content"] = $val;
            $this->view->render(MAIN_LAYOUT, $params);
        }

    }