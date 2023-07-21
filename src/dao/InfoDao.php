<?php
class InfoDao
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
        $result = $this->conn->query("SELECT * FROM info");
        return mysqli_fetch_assoc($result);
    }

    public function selectById($info_id)
    {
        $result = $this->conn->query("SELECT * FROM info WHERE info_id = $info_id");
        return $this->schematize(mysqli_fetch_assoc($result));
    }

    // public function update(
    //     $info_name,
    //     $info_email,
    //     $info_services
    // ) {
    //     return $this->conn->query("
    //         UPDATE info SET 
    //             info_name='$info_name',
    //             info_email='$info_email',
    //             info_services='$info_services'
    //     ");
    // }

    public function schematize($row)
    {
        return $row;
    }
}
