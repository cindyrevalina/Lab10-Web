<?php
// lib/database.php - Versi Sederhana
class Database {
    public $conn;
    
    public function __construct() {
        // Load config
        $config = include 'config/config.php';
        
        $this->conn = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['db_name']
        );
        
        if ($this->conn->connect_error) {
            throw new Exception("Koneksi gagal: " . $this->conn->connect_error);
        }
    }
    
    public function get($table, $where = null) {
        $sql = "SELECT * FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        
        $result = $this->conn->query($sql);
        if (!$result) {
            throw new Exception("Query error: " . $this->conn->error);
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }
    
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>