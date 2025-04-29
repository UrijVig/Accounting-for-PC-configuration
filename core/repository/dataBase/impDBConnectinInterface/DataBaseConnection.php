<?php
    class DataBaseConnection implements DBConnectionInterface{
        private $pdo;

        public function __construct($attr, $user, $password, $opts) {
            try {
                $this->pdo = new PDO($attr, $user, $password, $opts);
                // echo "Подключение к базе данных успешно!";
            } catch (PDOException $e) {
                echo "Ошибка при попытке подключения к базе данных" . $e->getMessage();
            }
        }
        public function getPDO(){
            return $this->pdo;
        }
        /**
         * @todo отредактировать после добавления системы пользователей!
         */
        public function getUserRole(){
            return "comming soon";
        }
    }