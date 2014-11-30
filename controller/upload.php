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
        $results = $model->getResult();

        $header_view = new View("header");
        $result_view = new View("upload");
        $footer_view = new View("footer");

        $result_view->setData($results);

        $header_view->display();
        $result_view->display();
        $footer_view->display();
    }


}