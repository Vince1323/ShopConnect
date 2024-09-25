<?php
class BaseModel {
    protected $conn;

    public function __construct() {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "Vinyjeff";
        $db_name = "shopconnect";

        $this->conn = new mysqli($db_host, $db_user, $db_password, $db_name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
?>
