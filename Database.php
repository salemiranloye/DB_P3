<?php
class Database {
    public function getConnection() {
        $dbHost = "localhost";
        $dbName = "AMDB";
        $dbUser = "root";
        $dbPassword = "";

        try {
            $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        } catch (PDOException $e) {
            // Better error handling
            die("Database Connection Error: " . $e->getMessage());
        }
    }
}
?>