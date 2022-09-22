<?php
class UserDao
{
    private $conn;
    public function __construct($proyect)
    {
        $this->conn = new Mysql($proyect);
    }
    public function getLastId()
    {
        return $this->conn->getLastId();
    }
    public function select()
    {
        return $this->conn->query("SELECT * FROM user");
    }
    public function selectById($user_id)
    {
        return $this->conn->query("SELECT * FROM user WHERE user_id = $user_id");
    }
    public function login($user_user, $user_pass)
    {
        return $this->conn->query("
            SELECT * FROM user 
            WHERE user_user = '$user_user' AND user_pass = '$user_pass'
        ");
    }
    public function insert(
        $user_name,
        $user_user,
        $user_pass,
        $user_type
    ) {
        return $this->conn->query("
            INSERT INTO user SET 
                user_name='$user_name', 
                user_user='$user_user',
                user_pass='$user_pass',
                user_type=$user_type
        ");
    }
    public function update(
        $user_name,
        $user_user,
        $user_pass,
        $user_type,
        $user_id
    ) {
        return $this->conn->query("
            UPDATE user SET 
                user_name='$user_name', 
                user_user='$user_user',
                user_pass='$user_pass',
                user_type=$user_type
            WHERE user_id = $user_id 
        ");
    }
    public function delete($user_id)
    {
        return $this->conn->query("DELETE FROM user WHERE user_id = $user_id ");
    }
}
