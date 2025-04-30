<?php 
    abstract class AbstractController{
        protected $view;

        public function __construct($view) {
            $this->view = $view;
        }
        abstract protected function render($val);

        public function action404()
        {
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
        }
        public function action500()
        {
            header("HTTP/1.1 500 Internal Server Error");
            header("Status: 500 Internal Server Error");
        }
    }