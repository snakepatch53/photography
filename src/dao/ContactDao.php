<?php
class ContactDao
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
        $result = $this->conn->query("SELECT * FROM contact");
        if (empty($result)) return false;
        $contacts = [];

        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
        return $contacts;
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
