<?php
class ContactDao
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
        return $this->conn->query("SELECT * FROM contact");
    }
    public function selectById($contact_id)
    {
        return $this->conn->query("SELECT * FROM contact WHERE contact_id = $contact_id");
    }
    public function insert(
        $contact_name,
        $contact_link,
        $contact_icon,
        $contact_color
    ) {
        return $this->conn->query("
            INSERT INTO contact SET 
                contact_name='$contact_name',
                contact_link='$contact_link',
                contact_icon='$contact_icon',
                contact_color='$contact_color'
        ");
    }
    public function update(
        $contact_name,
        $contact_link,
        $contact_icon,
        $contact_color,
        $contact_id
    ) {
        return $this->conn->query("
            UPDATE contact SET 
                contact_name='$contact_name',
                contact_link='$contact_link',
                contact_icon='$contact_icon',
                contact_color='$contact_color'
            WHERE contact_id = $contact_id 
        ");
    }
    public function delete($contact_id)
    {
        return $this->conn->query("DELETE FROM contact WHERE contact_id = $contact_id ");
    }
}
