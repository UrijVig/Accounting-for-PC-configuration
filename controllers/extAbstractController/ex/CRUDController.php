<?php 
    class CRUDController extends ReadController{
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
            if ($method === "POST"){
                $tablename = $_POST['tablename'];
                $target = $_POST['target'];
                if ($tablename === "peripheries") $columns = "name";
                else $columns = "serial_number";
                switch ($param[0]) {
                    case "delete":
                        $this->storageDataService->deleteRecord($tablename, $columns, $target);
                        break;
                    case "update":
                        header("Location: /update?tablename=$tablename&columns=$columns&target=$target");
                        exit;
                    default:
                        throw new RuntimeException("Error statement");
                }                
                header('Location: /storage');
                exit;
            } else {
                // echo $_SERVER['REQUEST_METHOD'];
                $this->title = "Storage";
                $this->meta_desc = "Оборудование на складе";
                $this->meta_key = "склад";             
                $data = $this->storageDataService->getFormattedData();
                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";
                $content = $this->view->render("Storage", ['data' => $data], true);
                $this->render($content);
            }
            
        }
        public function actionUpdate(string $method,array $param) {
            if ($method === "GET"){
                $tablename = $_GET['tablename'];
                $column = $_GET['columns'];
                $target = $_GET['target'];
                $data = $this->storageDataService->getDataFromTableByTarget($tablename, $column, $target);
                $this->title = "UpdateForm";
                $this->meta_desc = "Форма для редактирования";
                $this->meta_key = "редактор";
                $content = $this->view->render("update", 
                ['tablename'=>"$tablename",'data' => $data],
                 true);
                $this->render($content);
            } elseif ($method === "POST") {
                $data = $_POST;
                $tablename = $data['tablename'];
                unset($data['tablename']);
                if ($tablename === "peripheries") $columns = "name";
                else $columns = "serial_number";
                try {
                    $this->storageDataService->updateRecord($tablename, $data, $columns, $data['serial_number'] ?? $data['name']);
                    header('Location: /storage');
                    exit;
                } catch (Exception $e) {
                    echo "ups" . $e->getMessage();
                }
            } else {
                $this->render("");
            }
        }
    }