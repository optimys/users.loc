<?php

class Model_upload extends Model
{
    private $inserted = 0;
    private $notInserted = 0;
    private $notInsertedUsers = array();
    private $usersArray = array();

    public function __construct()
    {
        $this->db = Main::getDB();
    }

    public function setArray($usersArray)
    {
        $this->usersArray = $usersArray;
        $this->checkUser($this->usersArray);
    }

    private function checkUser($users = array())
    {   //для каждго элемента массива $users КАК $user (нам не интересны ключи)
        foreach ($users as $user) {
                // Для каждго массива $user как ключ(1..5)=> Значение [0]=>Alex
            foreach ($user as $param => $value) {
                if ($param === 2 || $param === 3) {
                    $check = $this->select($param, $value);
                    if (!$check) {
                        $this->insertNew($user);
                        $this->inserted++;
                    } else {
                        $this->notInserted++;
                        $this->notInsertedUsers[] = $value . " Already exists!";
                    }
                }
            }
        }
    }

    private function insertNew($items = array())
    {
        $newArray["first_name"] = $items[0];
        $newArray["last_name"]  = $items[1];
        $newArray["login"]      = $items[2];
        $newArray["email"]      = $items[3];
        $newArray["password"]   = $items[4];
        //$result = $this->db->query_insert("INSERT INTO users(`login`, `email`, `first_name`, `last_name`, `password`) VALUES ('{$login}', '{$email}', '{$first_name}', '{$last_name}', '{$password}')");
        $result = $this->db->query_insert('users', $newArray);
    }

    private function select($field, $value)
    {
        $field = $field === 2 ? "login" : "email";
        $result = $this->db->query_first("SELECT * FROM users WHERE {$field} = '{$value}'");
        return $result;
    }

    private function getNotInserted()
    {
        if ($this->notInserted) {
            return $this->notInserted;
        } else {
            return false;
        }
    }

    private function getSuccessInserted()
    {
        if ($this->inserted) {
            return $this->inserted;
        } else {
            return "0";
        }
    }

    public function getFailedUsers()
    {
       return $this->notInsertedUsers;
    }

    public function  getResult()
    {
        $resultArray = array(
            'success' => $this->getSuccessInserted(),
            'failed' => $this->getNotInserted(),
            'failed_users' => $this->getFailedUsers()
        );
        return $resultArray;
    }

}