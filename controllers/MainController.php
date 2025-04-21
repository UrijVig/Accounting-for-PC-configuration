<?php 
    class MainController extends AbstractController{
        protected $title;
        protected $meta_desc;
        protected $meta_key;

        public function __construct() {
            parent::__construct(new View(DIR_TMPL));
        }

        public function actionIndex(){
            $this->title = "hardchec";
            $this->meta_desc = "Описание главной страницы";
            $this->meta_key = "описание, описание главной страницы";
            $content = $this->view->render("index", array(), true);
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

        protected function render($str)
        {
            $params = [];
            $params["title"] = $this->title;
            $params["meta_desc"] = $this->meta_desc;
            $params["meta_key"] = $this->meta_key;
            $params["content"] = $str;
            $this->view->render(MAIN_LAYOUT, $params);
        }
    }