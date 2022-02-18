<?php

require 'dao/UserDaoMysql.php';

class Auth
{
    private $pdo;
    private $base;
    private $dao;

    public function __construct(PDO $pdo, $base)
    {
        $this->pdo = $pdo;
        $this->base = $base;
        $this->dao = new UserDaoMysql($this->pdo);
    }
    /**
     * Verificar token 
     */
    public function checkToken()
    {
        if (!empty($_SESSION['token'])) {
           $token = $_SESSION['token'];
           //$userDAO = new UserDaoMysql($this->pdo);
           $user = $this->dao->findByToken($token);
           if ($user) {
              return $user;
           }
        }

        header("Location ".$this->base."/login.php");
        exit;
    }

    public function validateLogin($email, $password)
    {
        //$userDAO = new UserDaoMysql($this->pdo);
        /**
         * Varificar Login
         */
        $user = $this->dao->findByEmail($email);
        if ($user) {
            
            if (password_verify($password, $user->password)) {
                $token = md5(time().rand(0, 9999));

                $_SESSION['token'] = $token;
                $user->token = $findByToken($token);
                $this->dao->update($user);

                return true;
            }
        }

        return false;
    }
    /**
     * E-mail if exists
     */
    public function emailExists($email)
    {
        //$userDAO = new UserDaoMysql($this->pdo);
        return $this->dao->findByEmail($email) ? true : false;
    }

    public function registerUser($name,$email, $password, $birthdate)
    {
        $userDAO = new UserDaoMysql($this->pdo);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0, 9999));

        $newUser = new User();
        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->password = $password;
        $newUser->birthdate = $birthdate;

        $this->dao->insert($newUser);

        $_SESSION['token'] = $token;
    }


}
?>