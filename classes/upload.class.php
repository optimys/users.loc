<?php

class Upload{

    private $pathToFile;
    public $pathToCsv = "";
    public $users = array();
    private $errors = array();

    public function __construct(){

        $this->pathToFile = $_SERVER['DOCUMENT_ROOT']."/uploads/file.csv";
        $this->users = $this->copyCsvFile();
    }

    private  function copyCsvFile(){

        if(isset($_FILES['csv_file'])) {
            if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $this->pathToFile)) {
                return $this->getArrayFromFile();
            } else {
                $this->setUploadErrors("An error while copying to uploads directory");
            }
        }else{
            $this->setUploadErrors("CSV File wasted");
        }
    }

    private   function getArrayFromFile(){
        $file = fopen($this->pathToFile, 'r');
        $i=0;
        do{
            $i++;
            $newUsersArray[$i] =  fgetcsv($file, 0, ",");
        }while(!empty($newUsersArray[$i]) );

        array_shift($newUsersArray); //Removing 1-st array (fields names) from array
        array_pop($newUsersArray);//Removing 1-st array (fields names) from array
        return $newUsersArray;
    }

    public function resultOfUpload(){
        return $this->result;
    }

    private function setUploadErrors($message){
        $this->errors[] = $message;
    }

    public function getErrorMessage(){
        if(!empty($this->errors)){
            $errors = $this->errors;
            foreach($errors as $error){
                echo "<p class='alert alert-danger'>".$error."</p>";
            }
        }else{
            return false;
        }
    }
}