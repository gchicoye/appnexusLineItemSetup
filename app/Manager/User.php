<?php

namespace App\Manager;

class User extends Manager
{
	public function getUser()
	{
		curl_setopt($this->ch, CURLOPT_URL, $this->apiEndPoint."/user?current");
		
		$response= curl_exec($this->ch);
		$response = json_decode($response);
		return $response->response->user;
	}
}