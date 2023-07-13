<?php
	class dbconn
	{
		private $host;
		private $username;
		private $password;
		private $dbname;
		protected $conn;
		function __construct()
		{
			$this->host = "localhost";
			$this->username = "hififilter";
			$this->password = "6L7l9D9h";
			$this->dbname = "hififilter";
			// $this->host = "localhost";
			// $this->username = "root";
			// $this->password = "";
			// $this->dbname = "hififilter";
		}
		function Connect_To_Database(){
			try{
				$this->conn=new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->username, $this->password);
				$this->conn->exec("SET NAMES 'utf8'");
			}
			catch(PDOException $e){
				echo $e->getMessage();
				echo "Hiba a kapcsolatban";
			}

		}
	}


?>