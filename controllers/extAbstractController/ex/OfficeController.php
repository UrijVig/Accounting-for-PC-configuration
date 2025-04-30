<?php 
 class OfficeController extends OfficeMapController{
    public function actionOfficeInfo(){
        $this->title = "OfficeMap";
        $this->meta_desc = "Карта офиса";
        $this->meta_key = "офис";            
        $data = $this->oficeDataService->getDataFromTable(['locations', 'system_units']);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        $content = $this->view->render("officeInfo", ['locations' => $data['locations'], 'workplaces' => $data['system_units']], true);
        $this->render($content);
    }
 }