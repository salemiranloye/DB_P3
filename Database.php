<!-- Jordan Smith-Acquah 1002098372 -->
<!-- Salem Iranloye 1002156031 -->
 
<?php

class Database {

	public function getDatabaseConnection(){

		$dbHost = "localhost:3307";
		$dbName = "AMDB";
		$dbUser = "root";
		$dbPassword = "";

		try {
			// PDO in PHP (PHP Data Objects)
			$dbConnection = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPassword);
			$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbConnection;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}