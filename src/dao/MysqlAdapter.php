<?php
class MysqlAdapter
{
    private $conn;
    private $last_id;
    private $host;
    private $user;
    private $pass;
    private $name;
    private $port;
    public function __construct(string $host, string $user, string $pass, string $name, int $port = 3306)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;
        $this->port = $port;
    }

    public function query($sql)
    {
        $this->conectar();
        $resultado = mysqli_query($this->conn, $sql);
        $this->last_id = mysqli_insert_id($this->conn);
        $this->desconectar();
        return $resultado;
    }

    private function conectar()
    {
        $this->conn = mysqli_connect(
            $this->host,
            $this->user,
            $this->pass,
            $this->name,
            $this->port
        );
        // mysqli_set_charset($this->conn, "utf8");
        return $this->conn;
    }

    private function desconectar()
    {
        mysqli_close($this->conn);
    }

    public function getLastId()
    {
        return $this->last_id;
    }

    public function getConn()
    {
        return $this->conn;
    }
}




class Migration
{
    private string $host;
    private string $user;
    private string $pass;
    private string $name;
    private int $port;

    private string $db_name;
    public array $db_tables = [];

    private $current_table;

    public function __construct(string $host, string $user, string $pass, string $name, int $port = 3306)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;
        $this->port = $port;
    }

    public function setDbName(string $name)
    {
        $this->db_name = $name;
        return $this;
    }

    public function addTable(string $name)
    {
        $this->current_table = $name;
        $this->db_tables[$name] = [];
        return $this;
    }

    public function addColumn(array $data)
    {
        if (empty($data['fk'])) $data['fk'] = null;
        if ($data['fk']) {
            if (empty($data['fk_table'])) throw new Exception("Foreign key table is required");
            if (empty($data['fk_column'])) throw new Exception("Foreign key column is required");
            if (empty($data['delete'])) $data['delete'] = false;
            $fk = $data['fk'];
            $name = $data['fk_table'];
            $column = $data['fk_column'];
            $delete = $data['delete'];
            $fk_name  = $fk . "_" . $name;

            $this->db_tables[$this->current_table][$fk_name] = [
                "fk_name" => $fk_name,
                "fk" => $fk,
                "fk_table" => $name,
                "fk_column" => $column,
                "fk_delete" => $delete ? "ON DELETE CASCADE" : ""
            ];
            return $this;
        }

        if (empty($data['name'])) throw new Exception("Column name is required");
        if (empty($data['type'])) throw new Exception("Column type is required");
        if (empty($data['null'])) $data['null'] = false;
        if (empty($data['primary'])) $data['primary'] = false;
        if (empty($data['auto_increment'])) $data['auto_increment'] = false;
        if (empty($data['default'])) $data['default'] = null;
        $name = $data['name'];
        $type = $data['type'];

        $this->db_tables[$this->current_table][$name] = [
            'type' => $type,
            'null' => $data['null'],
            'primary' => $data['primary'],
            'auto_increment' => $data['auto_increment'],
            'default' => $data['default'],
            'fk' => $data['fk']
        ];
        return $this;
    }

    private function getConnection()
    {
        $connect = mysqli_connect($this->host, $this->user, $this->pass, $this->name, $this->port);
        if (!$connect) die("Connection failed: " . mysqli_connect_error());
        return $connect;
    }

    private function dropDatabase($connecion)
    {
        $sql = "DROP DATABASE IF EXISTS $this->db_name;";
        if (mysqli_query($connecion, $sql)) {
            echo "Database droped successfully" . "<br>";
        } else {
            echo "Error creating database: " . mysqli_error($connecion) . "<br>";
        }
        return $sql;
    }

    private function createDatabase($connecion)
    {
        $sql = "CREATE DATABASE IF NOT EXISTS $this->db_name;";
        if (mysqli_query($connecion, $sql)) {
            echo "Database created successfully" . "<br>";
        } else {
            echo "Error creating database: " . mysqli_error($connecion) . "<br>";
        }
        return $sql;
    }

    private function createTable($connection, $table, $columns)
    {
        mysqli_select_db($connection, $this->db_name);
        $sql = "CREATE TABLE $table (";
        foreach ($columns as $column => $data) {
            if ($data['fk']) {
                $sql .= "FOREIGN KEY ({$data['fk']}) REFERENCES {$data['fk_table']} ({$data['fk_column']}) {$data['fk_delete']},";
            } else {

                $sql .= "$column {$data['type']}";
                if ($data['primary']) $sql .= " PRIMARY KEY";
                if ($data['auto_increment']) $sql .= " AUTO_INCREMENT";
                if ($data['null']) $sql .= " NOT NULL";
                if ($data['default'] !== null) $sql .= " DEFAULT '{$data['default']}'";
                $sql .= ",";
            }
        }
        $sql = substr($sql, 0, -1);
        $sql .= ") ENGINE INNODB;";
        if (mysqli_query($connection, $sql)) {
            echo "Table $table created successfully" . "<br>";
        } else {
            echo "Error creating table $table: " . mysqli_error($connection) . "<br>";
        }
        return $sql;
    }


    public function migrate()
    {
        //creamos la conexion
        $connection = $this->getConnection();

        //creamos la base de datos
        $this->dropDatabase($connection);
        $this->createDatabase($connection);

        // vaciamos la base de datos
        foreach ($this->db_tables as $table => $columns) {
            $this->createTable($connection, $table, $columns);
        }


        // close connection
        mysqli_close($connection);
    }

    public function migrateFromSqlFile(string $file_path)
    {
        $connection = $this->getConnection();
        $tables = mysqli_query($connection, "SHOW TABLES");
        $sql = "SET FOREIGN_KEY_CHECKS = 0;";
        while ($row = mysqli_fetch_array($tables)) {
            $sql .= "DROP TABLE IF EXISTS " . $row[0] . ";";
        }
        $sql .= "SET FOREIGN_KEY_CHECKS = 1;";
        $sql .= file_get_contents($file_path);
        if (mysqli_multi_query($connection, $sql)) {
            echo "Tables created successfully" . "<br>";
        } else {
            echo "Error executing sql file: " . mysqli_error($connection) . "<br>";
        }
        mysqli_close($connection);
    }
}
