<?php
class CategoryDao
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
        return $this->conn->query("SELECT * FROM category");
    }
    public function selectById($category_id)
    {
        return $this->conn->query("SELECT * FROM category WHERE category_id = $category_id");
    }
    public function insert(
        $category_name,
        $category_descr
    ) {
        return $this->conn->query("
            INSERT INTO category SET 
                category_name='$category_name', 
                category_descr='$category_descr'
        ");
    }
    public function update(
        $category_name,
        $category_descr,
        $category_id
    ) {
        return $this->conn->query("
            UPDATE category SET 
                category_name='$category_name', 
                category_descr='$category_descr'
            WHERE category_id = $category_id 
        ");
    }
    public function delete($category_id)
    {
        return $this->conn->query("DELETE FROM category WHERE category_id = $category_id ");
    }
}
