<?php

namespace App\Manager;

class InsertionOrder extends Manager
{
	protected $id;
	protected $name;
	protected $advertiserId;

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
    		"insertion-order" => array(
    			"name" => $this->name,
                "code" => $this->nameToCode()
    		)
    	);
    	return $this->postData($data, $this->apiEndPoint."/insertion-order?advertiser_id=".$this->advertiserId);
    }

    public function updateFromName()
    {
        $data = array(
            "insertion-order" => array(
                "id" => $this->id,
                "name" => $this->name,
                "code" => $this->nameToCode()
            )
        );
        return $this->putData($data, $this->apiEndPoint."/insertion-order?id?=".$this->id."advertiser_id=".$this->advertiserId);
    }


}