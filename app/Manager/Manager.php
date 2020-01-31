<?php

namespace App\Manager;

class Manager 
{
	protected $authorization;
	protected $apiEndPoint;
	protected $ch;
	protected $className;

	public function __construct()
	{
		$this->initCurl();
		$this->apiEndPoint = parse_ini_file(__DIR__.'/../../config/config.ini')['apiEndPoint'];

		$className = explode("\\", get_class($this));

		$this->className  = lcfirst($className[count($className)-1]);
		switch ($this->className){
			case "lineItem":
				$this->className = "line-item";
				break;
			case "insertionOrder":
				$this->className = "insertion-order";
				break;
		}
	}

	public function setAuthorization($authorization)
	{
		$this->authorization = $authorization;
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("'Cache-Control': 'no-cache'", $this->authorization, 'Content-Type: application/json',  'charset=utf-8' ));
		return $this;
	}

	public function initCurl()
	{
		$this->ch = curl_init();
		
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_HEADER, false);
		return $this;
	}

	public function setFromName()
    {
    	if($this->name == ""){ die("$this->className class: A name is required");}
    	if($this->getFromName() == false){
    		$this->createFromName();
    	} else {
    		foreach (get_object_vars($this) as $key => $value) {
    			if(!in_array($key, ['authorization','apiEndPoint', 'ch',  'className', 'id'])){
    				$this->$key = $value;
    			}
    		}
    		$this->updateFromName();
    	}
    	return $this;
    }

    public function postData($data, $url = "")
    {
    	if($url == ""){
    		$url = $this->apiEndPoint."/".$this->className;
    	}
    	
    	echo "Create From Name\n".$url."\n";
    	curl_setopt($this->ch, CURLOPT_URL, $url);
    	curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "POST");
    	curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
    	$response= curl_exec($this->ch);
    	echo $response."\n\n";
		$response = json_decode($response);
		if(isset($response->response->{$this->className}) == 1){
			$this->hydrate($response->response->{$this->className});
			return $this;
		} else {
			return false;
		}
    }

    public function putData($data, $url = "")
    {
    	if($url == ""){
    		$url = $this->apiEndPoint."/".$this->className;
    	}
    	
    	echo "Update From Name\n".$url."\n";
    	curl_setopt($this->ch, CURLOPT_URL, $url);
    	curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "PUT");
    	curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
    	$response= curl_exec($this->ch);
    	echo $response."\n\n";
		$response = json_decode($response);
		if(isset($response->response->{$this->className}) == 1){
			$this->hydrate($response->response->{$this->className});
			return $this;
		} else {
			return false;
		}
    }

    public function getData($url = "")
    {
    	if($url == ""){
    		$url = $this->apiEndPoint."/".$this->className."?search=".urlencode($this->name);
    	}
		echo "Get From Name\n".$url."\n";
		curl_setopt($this->ch, CURLOPT_URL, $url);
		$response= curl_exec($this->ch);
		echo $response."\n\n";
		$response = json_decode($response);
		if(isset($response->response->{$this->className."s"}) && count($response->response->{$this->className."s"}) >0){
			$this->hydrate($response->response->{$this->className."s"}[0]);
			return $this;
		} else {
			return false;
		}
    }

    public function getAll()
	{
		$url = $this->apiEndPoint."/".$this->className;
		echo "Get All\n".$url."\n";
		curl_setopt($this->ch, CURLOPT_URL, $url);
		$response= curl_exec($this->ch);
	
		$response = json_decode($response);
		
		return $response->response->{$this->className."s"};
	}

	public function getFromName()
	{
		if($this->name == ""){ die("$this->className class: A name is required");}
		return $this->getData();
		
	}

	public function getFromId()
	{
		if($this->id == ""){ die("$this->className class: An Id is required");}
		$url = $this->apiEndPoint."/".$this->className."?id=".urlencode($this->id);
		echo "Get From Name\n".$url."\n";
		curl_setopt($this->ch, CURLOPT_URL, $url);
		$response= curl_exec($this->ch);
		echo $response."\n\n";
		$response = json_decode($response);
		if(isset($response->response->{$this->className})){
			echo json_encode($response->response->{$this->className}, JSON_PRETTY_PRINT);
			exit;
			$this->hydrate($response->response->{$this->className});
			return $this;
		} else {
			return false;
		}		
	}

	public function getAllFromAdvertiserId()
	{
		if($this->advertiserId == ""){ die("$this->className class: An advertiserId is required");}
		$url = $this->apiEndPoint."/".$this->className."?advertiser_id=".urlencode($this->advertiserId);
		echo "Get From AdvertiserId\n".$url."\n";
		curl_setopt($this->ch, CURLOPT_URL, $url);
		$response= curl_exec($this->ch);
		echo $response."\n\n";
		$response = json_decode($response);
		if(isset($response->response->{$this->className."s"})){
			return $response->response->{$this->className."s"};
		} else {
			return false;
		}
		return ;	
	}

	public function nameToCode()
	{
		return strtolower(str_replace(" ", "_", $this->name));
	}



}