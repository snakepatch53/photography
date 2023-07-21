<?php
class CategoryDao
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
        $result = $this->conn->query("SELECT * FROM category");
        if (mysqli_num_rows($result) == 0) return [];

        $categories = [];
        while ($category = mysqli_fetch_assoc($result)) {
            $categories[] = $this->schematize($category);
        }
        return $categories;
    }

    public function selectById($category_id)
    {
        $result = $this->conn->query("SELECT * FROM category WHERE category_id = $category_id");
        if (mysqli_num_rows($result) == 0) return false;
        return $this->schematize(mysqli_fetch_assoc($result));
    }

    public function insert(
        $category_name,
        $category_descr,
        $category_photo
    ) {
        $result = $this->conn->query("
            INSERT INTO category SET 
                category_name='$category_name', 
                category_descr='$category_descr',
                category_photo='$category_photo'
        ");
        if (!$result) return false;
        return $this->selectById($this->getLastId());
    }

    public function update(
        $category_name,
        $category_descr,
        $category_photo,
        $category_id
    ) {
        $result = $this->conn->query("
            UPDATE category SET 
                category_name='$category_name', 
                category_descr='$category_descr',
                category_photo='$category_photo'
            WHERE category_id = $category_id 
        ");
        if (!$result) return false;
        return $this->selectById($category_id);
    }

    public function delete($category_id)
    {
        $result = $this->conn->query("DELETE FROM category WHERE category_id = $category_id ");
        if (!$result) return false;
        return true;
    }

    public function schematize($row)
    {
        // portada
        $category_photo_url = $_ENV['HTTP_DOMAIN'] . '/public/img.categories/' . $row['category_photo'];
        if (!file_exists('./public/img.categories/' . $row['category_photo'])) {
            $category_photo_url = $_ENV['HTTP_DOMAIN'] . '/public/img/notfound.gif';
        }
        $row['category_photo_url'] = $category_photo_url;
        return $row;
    }
}
