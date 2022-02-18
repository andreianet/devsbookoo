<?php

require 'models/User.php';

class UserDaoMysql implements UserDAO
{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }
    /**
     * Mount the array and return the obejct
     */
    private function generateUser($array)
    {
        $u = new User();
        $u->id = $array['id'] ?? 0;
        $u->email = $array['email'] ?? 0;
        $u->name = $array['name'] ?? 0;
        $u->birthday = $array['birthday'] ?? 0;
        $u->city = $array['city'] ?? 0;
        $u->work = $array['work'] ?? 0;
        $u->avatar = $array['avatar'] ?? 0;
        $u->cover = $array['cover'] ?? 0;
        $u->token = $array['token'] ?? 0;

        return $u;

    }
    public function findByToken($token)
    {
        if (!empty($token)) {
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE token = :token");
            $ql->bindParam(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
               $data = $sql->fetch(PDO::FETCH_ASSOC);
               $user = $this->generateUser($data);
               return $user;
            }
        }
        return false;
    }
}
?>