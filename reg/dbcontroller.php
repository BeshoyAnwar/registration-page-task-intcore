<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "accounts";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
		$mysqli = new mysqli($this->host,$this->user,$this->password);
		$sql='
CREATE TABLE IF NOT EXISTS `accounts`.`users` 
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `avatar` VARCHAR(100) NOT NULL,
PRIMARY KEY (`id`) 
)';
$mysqli->query($sql);

	}
	
	function connectDB() {
	    $conn = mysqli_connect($this->host,$this->user,$this->password, $this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn, $query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
	    $result  = $this->runQuery($query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
	
	function updateQuery($query) {
	    $result = mysqli_query($this->conn, $query);
		if (!$result) {
		    die('Invalid query: ' . mysqli_error($this->conn));
		} else {
			return $result;
		}
	}
	
	function insertQuery($query) {
	    $result = mysqli_query($this->conn, $query);
		if (!$result) {
		    $_SESSION['message'] = 'User could not be added to the database!';
			return False;
		} else {
			return True;
				
		}
	}
	
	function deleteQuery($query) {
	    $result = mysqli_query($this->conn, $query);
		if (!$result) {
		    die('Invalid query: ' . mysqli_error($this->conn));
		} else {
			return $result;
		}
	}
	function findmail($email) {
		$query = "SELECT * FROM users where email = '" . $email . "'";
		$result = mysqli_query($this->conn, $query);
		$findemail=False;
		while( $row = $result->fetch_assoc() ){ 
			return True;
		}
		return False;
	}
	function getdata($query) {
		$result = mysqli_query($this->conn, $query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
			echo "hello";
		}		
		if(!empty($resultset)){
			$findemail=True;
			return array($findemail,$resultset);
			
			
		}
		else{
			$findemail=False;
			return array($findemail);
		}
		return $resultset;
	}
}
?>
