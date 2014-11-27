<?php

class Upload{
    private $pathToFile;

    public function __construct($pathToFile = ""){
        $this->pathToFile = $pathToFile;
    }
    public  function getArrayFromFile(){
        $file = fopen($this->pathToFile, 'r');
        do{
            $newUsersArray =  fgetcsv($file,100,";");
        }while(
            fgetcsv($file,100,";")
        );
        return $newUsersArray;
    }

    public function copyFile(){
        //copy file to storage
    }

    public function resultOfUpload(){
        //return tru if success
    }
}