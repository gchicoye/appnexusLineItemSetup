<?php


namespace App\Connexion;

class Connexion
{
	protected $credentials;
	protected $authorization;

	public function setCredentials()
	{
		$config = parse_ini_file(__DIR__.'/../../config/config.ini');
		$auth = 
		$this->credentials = array(
			"auth" => array(
				"username" => $config['username'],
				"password" => $config['password']
			)
		);
		return $this;
	}

	public function getAuthorization(){
		return $this->authorization;
	}

	public function renewToken()
	{
		$ch = $this->initCurl();

		$apiEndPoint = parse_ini_file(__DIR__.'/../../config/config.ini')['apiEndPoint'];

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, $apiEndPoint."/auth");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->credentials));

		$response= curl_exec($ch);

		$response = json_decode($response);

		if(isset($response->response->token))
		{
			$this->authorization = "Authorization: ".$response->response->token;
			return $this;
		}
		else{
			echo json_encode($response);
			die("\n\n\n===========THERE IS A BUG WITHIN THE API==========\n\n\n");
		}
		
		
	}

	protected function initCurl()
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		
		return $ch;
	}

}