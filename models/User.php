<?php

class User
{
    public $id;
    public $email;
    public $password;
    public $name;
    public $birthDate;
    public $city;
    public $work;
    public $avatar;
    public $cover;
    public $token;
}
//for DAO
interface UserDAO{
    
    public function findByToken($token);
    
}


?>