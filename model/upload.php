<?php
class Model_upload extends Model{
    private $inserted = 0;
    private $notInserted = 0;
    private $notInsertedUsers = array();
    private $usersArray = array();

    public  function __construct(){
        $this->db = Main::getDB();
    }

    public function setArray($usersArray){
        $this->usersArray = $usersArray;
    }

    private  function checkUser($usersInput = array()){
        foreach($usersInput as $user => $field){
            foreach($field as $value){
                if($field ==='First name' || $field === 'E-mail'){
                    $check = $this->select($field, $value);
                    if(!$check){
                        $this->insertNew('users', $user);
                        $this->inserted++;
                    }else{
                        $this->notInserted++;
                        $this->notInsertedUsers[] = $usersInput['First name']."Already exists!";
                    }
                }
            }
        }
    }

    private function insertNew($table, $items = array()){
        list($first_name, $last_name, $login, $email, $password)= $items;
        foreach($items as $item => $fields){
            $this->db->query_first("INSERT INTO $table(`login`, `email`, `first_name`, `last_name`, `password`) VALUES ($login, $email, $first_name, $last_name, $password)");
        }
    }

    private  function select($field, $value){
        $result = $this->db->query_first("SELECT * WHERE {$field} = {$value}");
        return $result;
    }

    private  function getNotInserted(){
        if($this->notInserted){
            return $this->notInserted;
        }else{
            return false;
        }
    }
    private  function getSuccessInserted(){
        if($this->inserted){
            return $this->inserted;
        }else{
            return "0";
        }
    }
    public function getFaildUsers(){
        $faildString = "";
        foreach($this->notInsertedUsers as $user){
            $faildString .= "<p calss='bg-warning'>".$user."</p>";
        }
    }

    public function  getResult(){
        $resultArray=array(
            'success' => $this->getSuccessInserted(),
            'faild' => $this->getNotInserted(),
            'fail_users' => $this->getFaildUsers()
        );
        return $resultArray;
    }

}