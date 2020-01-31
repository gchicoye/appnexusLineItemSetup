<?php

namespace App\Manager;

class Advertiser extends Manager
{
	protected $id;
	protected $name = "";
    protected $code = "";
	
	public function __call($m,$p)
	{     
        $v = lcfirst(substr($m,3));
        if (!strncasecmp($m,'get',3))return $this->$v;
        if (!strncasecmp($m,'set',3)){
        	$this->$v = $p[0];
        	return $this;
        }
    }

    public function createFromName()
    {
        $data = array(
    		"advertiser" => array(
    			"name" => $this->name,
                "code" => $this->nameToCode()
    		)
    	);
    	return $this->postData($data);
    }

    public function updateFromName()
    {
        $data = array(
            "advertiser" => array(
                "id" => $this->id,
                "name" => $this->name,
                "code" => $this->nameToCode()
            )
        );
        return $this->putData($data, $url = $this->apiEndPoint."/advertiser?advertiser_id=".$this->id);
    }
	
	protected function hydrate($data)
	{
		
        $this->id = $data->id;
		$this->name = $data->name;
        $this->code = $data->code;
		return $this;
	}

}