<?php

class  Controller_upload extends Controller{
    public function index(){
        if(isset($_FILES['file'])){
            move_uploaded_file($_FILES['file']['temp_name'], "uploaded.csv");
            $newUsersArray = new Upload('uploaded.csv');
            $usersArray = $newUsersArray ->getArrayFromFile();
        };

        $model = Controller::loadModel('upload');
        $model->setArray($usersArray);
        $results = $model->getFaildUsers();

        $header_view = new View("header");
        $result_view = new View("upload");
        $footer_view = new View("footer");

        $result_view->setData($results);

        $header_view->display();
        $result_view->display();
        $footer_view->display();
    }


}