<?php
class  Controller_upload extends Controller{

    public function index(){

        $newFile = new Upload();
        if(!$newFile->getErrorMessage()){
            $usersArray = $newFile->users;
        }else{
            $newFile->getErrorMessage();
        }

        $model = Controller::loadModel('upload');
        $model->setArray($usersArray);
        $results = $model->getResult(); //The data that will be print in view

        $header_view = new View("header");
        $result_view = new View("upload");
        $footer_view = new View("footer");

        $result_view->setData($results);    //Export data to view

        $header_view->display();
        $result_view->display();
        $footer_view->display();
    }


}