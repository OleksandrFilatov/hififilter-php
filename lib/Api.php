<?php
	class Api
	{
		private $token;
		private $ip;

		function __construct()
		{
			$this->ip = self::getLocalIP();
		}
		
		function getLocalIP(){
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				return $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			return $_SERVER['REMOTE_ADDR'];	
		}

		function searchItemsByID($id){
			$id = "%".$id."%";
			$res = $this->conn->prepare("SELECT * FROM products WHERE id LIKE ? LIMIT 10");
			$res->bindparam(1, $id);
			$res->execute();
			return $res->fetchall();
		}


		function connectAPI(){
    
			$ch = curl_init();
		
			curl_setopt($ch, CURLOPT_URL,"https://b2b.hifi-filter.com/api/authentication/login");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query(array('username' => 'jjakab@specialfilter.hu','password' => 'Filter02.', 'ip' => $this->ip, 'hash' => false)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		
			$server_output = curl_exec($ch);
			$getInfo = json_decode($server_output, true);
    		curl_close ($ch);
			$this->token = $getInfo['sessionToken'];
		}

		function getDataByReference($search)
		{
			$customHeaders = array('Content-Type: application/x-www-form-urlencoded', 'token: '.$this->token, 'login: jjakab@specialfilter.hu', 'language: en-GB');
			$cURLConnection = curl_init();

			curl_setopt($cURLConnection, CURLOPT_URL, 'https://b2b.hifi-filter.com/api/article/search?reference='.$search);
			curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($cURLConnection, CURLOPT_POST, 0);
			curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $customHeaders);
			curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

			$list = curl_exec($cURLConnection);
			curl_close($cURLConnection);
			return json_decode($list);
		}


		function getPrice($id)
		{
			$cURLConnection = curl_init();

			$data = array(
				['reference' => $id,
				'quantity' => 1]
			);
			$payload = json_encode($data);
			curl_setopt($cURLConnection, CURLOPT_URL, 'https://b2b.hifi-filter.com/api/article/price?publicPrice=false');
			curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($cURLConnection, CURLOPT_POST, 1);
			$customHeaders = array('Content-Type:application/json', 'token: '.$this->token, 'login: jjakab@specialfilter.hu', 'language: en-GB');
			curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $customHeaders);
			curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($cURLConnection, CURLOPT_POSTFIELDS,  $payload );
			$list = curl_exec($cURLConnection);
			curl_close($cURLConnection);
			return json_decode($list);
		}


		function getTechnicalData($id)
		{
			$cURLConnection = curl_init();

			$data = array(
				['reference' => $id,
				'quantity' => 1]
			);
			$payload = json_encode($data);
			curl_setopt($cURLConnection, CURLOPT_URL, 'https://b2b.hifi-filter.com/api/article/availability');
			curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($cURLConnection, CURLOPT_POST, 1);
			$customHeaders = array('Content-Type:application/json', 'token: '.$this->token, 'login: jjakab@specialfilter.hu', 'language: en-GB');
			curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $customHeaders);
			curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($cURLConnection, CURLOPT_POSTFIELDS,  $payload );
			$list = curl_exec($cURLConnection);
			curl_close($cURLConnection);
			return json_decode($list);
		}



		function getFilters($search)
		{
			$customHeaders = array('Content-Type: application/x-www-form-urlencoded', 'token: '.$this->token, 'login: jjakab@specialfilter.hu', 'language: en-GB');
			$cURLConnection = curl_init();

			curl_setopt($cURLConnection, CURLOPT_URL, 'https://b2b.hifi-filter.com/api/article/filter/'.$search);
			curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($cURLConnection, CURLOPT_POST, 0);
			curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $customHeaders);
			curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

			$list = curl_exec($cURLConnection);
			curl_close($cURLConnection);
			return json_decode($list);
		}




		function closeAPI(){
			$ch = curl_init();
		
			curl_setopt($ch, CURLOPT_URL,"https://b2b.hifi-filter.com/api/authentication/logout");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query(array('username' => 'JAKAB JOSEPH', "token" => $this->token)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		
			$server_output = curl_exec($ch);
			$getInfo = json_decode($server_output, true);
			curl_close ($ch);
		}
		
    }
?>