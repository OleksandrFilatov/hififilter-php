<?php
	class Search extends dbconn
	{
		function __construct()
		{
			parent::__construct();
			parent::Connect_To_Database();
		}
		
		function searchItemsByID($id){
			$id = "%".$id."%";
			$res = $this->conn->prepare("SELECT * FROM products WHERE id LIKE ? LIMIT 10");
			$res->bindparam(1, $id);
			$res->execute();
			return $res->fetchall();
		}
    }
?>