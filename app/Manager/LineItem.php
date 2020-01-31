<?php

namespace App\Manager;

class LineItem extends Manager
{
	protected $advertiserId;
    protected $profileId;
    protected $creatives;

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
    	$foo = explode("_",$this->name);
        $value = (float) $foo[count($foo)-1];

        $data = array(
    		"line-item" => array(
    			"name" => $this->name,
                "code" => $this->nameToCode(),
    			"advertiser_id" => $this->advertiserId,
                "profile_id" => $this->profileId,
    			"revenue_type" => "cpm",
                "manage_creative" => true,
                "revenue_value" => $value,
                "creatives" => $this->setCreativesArray()
    		)
    	);
    	return $this->postData($data, $this->apiEndPoint."/line-item?advertiser_id=".$this->advertiserId);
    }

    public function updateFromName()
    {
        $foo = explode("_",$this->name);
        $value = (float) $foo[count($foo)-1];

        $data = array(
            "line-item" => array(
                "name" => $this->name,
                "code" => $this->nameToCode(),
                "advertiser_id" => $this->advertiserId,
                "profile_id" => $this->profileId,
                "revenue_type" => "cpm",
                "manage_creative" => true,
                "revenue_value" => $value,
                "creatives" => $this->setCreativesArray()
            )
        );
        return $this->putData($data, $this->apiEndPoint."/line-item?id=".$this->id."&advertiser_id=".$this->advertiserId);
    }
	
	protected function hydrate($data)
	{
		
        $this->id = $data->id;
		$this->name = $data->name;
		return $this;
	}

    private function setCreativesArray()
    {
        $output = [];
        foreach ($this->creatives as $creative) {
            array_push($output, array("id" => $creative->getId()));
        }
        return $output;
    }
}