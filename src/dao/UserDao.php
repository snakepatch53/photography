<?php
class UserDao
{
    private MysqlAdapter $conn;
    public function __construct(MysqlAdapter $mysqlAdapter)
    {
        $this->conn = $mysqlAdapter;
    }

    public function getLastId()
    {
        return $this->conn->getLastId();
    }

    public function select()
    {
        $result = $this->conn->query("SELECT * FROM user");
        if (mysqli_num_rows($result) == 0) return false;
        $return = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        return $return;
    }

    public function selectById($user_id)
    {
        $result = $this->conn->query("SELECT * FROM user WHERE user_id = $user_id");
        if (mysqli_num_rows($result) == 0) return false;
        return mysqli_fetch_assoc($result);
    }

    public function login($user_user, $user_pass)
    {
        $result = $this->conn->query("
            SELECT * FROM user 
            WHERE user_user = '$user_user' AND user_pass = '$user_pass'
        ");
        if (mysqli_num_rows($result) > 0) return mysqli_fetch_assoc($result);
        return [];
    }

    public function insert(
        $user_name,
        $user_user,
        $user_pass,
        $user_type,
        $user_photo
    ) {
        $result = $this->conn->query("
            INSERT INTO user SET 
                user_name='$user_name', 
                user_user='$user_user',
                user_pass='$user_pass',
                user_type=$user_type,
                user_photo='$user_photo'
        ");
        if ($result) return $this->getLastId();
        return false;
    }

    public function update(
        $user_name,
        $user_user,
        $user_pass,
        $user_type,
        $user_photo,
        $user_id
    ) {
        return $this->conn->query("
            UPDATE user SET 
                user_name='$user_name', 
                user_user='$user_user',
                user_pass='$user_pass',
                user_type=$user_type,
                user_photo='$user_photo'
            WHERE user_id = $user_id 
        ");
    }

    public function delete($user_id)
    {
        $result = $this->conn->query("DELETE FROM user WHERE user_id = $user_id ");
        if ($result) return true;
        return false;
    }
}
