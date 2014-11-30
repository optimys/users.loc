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
            $check_email = $this->select('email', $user[3]);
            $check_login = $this->select('login', $user[2]);
            if ($check_email || $check_login ) {
                $this->notInserted++;
                $this->notInsertedUsers[] = $user;
            } else {
                $this->insertNew($user);
                $this->inserted++;
            }


        }
    }

    private function insertNew($items = array())
    {
        $newArray["first_name"] = $items[0];
        $newArray["last_name"] = $items[1];
        $newArray["login"] = $items[2];
        $newArray["email"] = $items[3];
        $newArray["password"] = $items[4];

        $result = $this->db->query_insert('users', $newArray);
        //$result = $this->db->query_insert("INSERT INTO users(`login`, `email`, `first_name`, `last_name`, `password`) VALUES ('{$login}', '{$email}', '{$first_name}', '{$last_name}', '{$password}')");
    }

    private function select($field, $value)
    {
        $result = $this->db->query_first("SELECT * FROM users WHERE {$field} = '{$value}'");
        return $result;
    }

    private function getNotInserted()
    {
        if ($this->notInserted) {
            return $this->notInserted;
        } else {
            return "0";
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
        $result_string[] = "No failed users detected";
        if (!empty($this->notInsertedUsers)) {
            $notInsertedUsers = $this->notInsertedUsers;
            foreach ($notInsertedUsers as $user) {
                array_pop($user);                   //Удаляем последне значение массива, там пароль, он не нужен в выводе
                $userInfo = implode(" | ", $user);  //Склеиваем оставшиеся данные в одну строку
                $result_string[] = $userInfo;                   //Заполняем массив полученными строками
            }
        }
        return $result_string;
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