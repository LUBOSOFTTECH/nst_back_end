<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database {
    private $uri = "mysql://avnadmin:AVNS_j_IIl1gBV5GfZx_-x-N@mysql-31aaee96-lubosoftenquiry-1923.l.aivencloud.com:10653/defaultdb?ssl-mode=REQUIRED";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        $fields = parse_url($this->uri);

        // Build the DSN including SSL settings
        $dsn = "mysql:";
        $dsn .= "host=" . $fields["host"];
        $dsn .= ";port=" . $fields["port"];
        $dsn .= ";dbname=" . ltrim($fields["path"], '/');
        $dsn .= ";sslmode=REQUIRED";

        try {
            $this->conn = new PDO($dsn, $fields["user"], $fields["pass"]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection successful!\n";
        } catch (PDOException $e) {
            error_log("Connection error: " . $e->getMessage());
            echo "Connection error: " . $e->getMessage();
            exit; // Exit on connection error
        }

        return $this->conn;
    }
}

$database = new Database();
$database->getConnection();
?>
