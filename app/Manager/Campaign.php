<?php

namespace App\Manager;

class Campaign extends Manager
{
	protected $id;
	protected $name = "";
    protected $code; 
    protected $advertiserId;
    protected $lineItemId;
	
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
    		"campaign" => array(
    			"name" => $this->name,
                "code" => $this->nameToCode(),
                "line_item_id" => $this->lineItemId,
                "inventory_type" => "direct"
    		)
    	);
    	return $this->postData($data, $this->apiEndPoint."/campaign?advertiser_id=".$this->advertiserId);
    }

    public function updateFromName()
    {
        $data = array(
            "campaign" => array(
                "name" => $this->name,
                "code" => $this->nameToCode(),
                "line_item_id" => $this->lineItemId,
                "inventory_type" => "direct"
            )
        );
        return $this->putData($data, $this->apiEndPoint."/campaign?id=".$this->id."&advertiser_id=".$this->advertiserId);
    }
	
	protected function hydrate($data)
	{
		
        $this->id = $data->id;
		$this->name = $data->name;
        $this->code = $data->code;
		return $this;
	}

}