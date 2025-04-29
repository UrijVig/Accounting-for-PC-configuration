<?php 
    interface DBConnectionInterface{
        public function getUserRole();
        public function getPDO();
    }