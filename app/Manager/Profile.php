<?php

namespace App\Manager;

class Profile extends Manager
{
    protected $id;
    protected $name;
    protected $bucket;
    protected $advertiserCode;
    protected $advertiserId;
    protected $format;


	public function __call($m,$p)
	{     
        $v = lcfirst(substr($m,3));
        if (!strncasecmp($m,'get',3))return $this->$v;
        if (!strncasecmp($m,'set',3)){
        	$this->$v = $p[0];
        	return $this;
        }
    }

    public function setFromBucket()
    {
        if($this->getFromBucket() == false){
            $this->createFromBucket();
        }
        return $this;
    }

    public function getFromBucket()
    {
        $code = $this->nameToCode();
        $url = $this->apiEndPoint."/profile?code=".$code."&advertiser_id=".$this->advertiserId;
        echo "Get From Bucket\n".$url."\n";
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $response= curl_exec($this->ch);
        echo $response."\n\n";
        $response = json_decode($response);


        if(isset($response->response->{$this->className})){
            $this->hydrate($response->response->{$this->className});
            return $this;
        } else {
            return false;
        }
    }


    public function createFromBucket()
    {
        $data = array(
            "profile" => array(
                "code" => $this->nameToCode(),
                "key_value_targets" => array(
                     "kv_expression" => array(
                        "header" => array(
                            "an_version" => "1.0",
                            "client_version" => "1.0"
                        ),
                        "exp" => array(
                            "typ" => "and",
                            "sbe" => [
                                array("exp" => 
                                    array(
                                        "typ" => "in",
                                        "vtp" => "sta",
                                        "key" => "hb_pb",
                                        "vsa" => [$this->bucket]
                                    )
                                ),
                                array("exp" => 
                                    array(
                                        "typ" => "in",
                                        "vtp" => "sta",
                                        "key" => "hb_format",
                                        "vsa" => [$this->format]
                                    )
                                )
                            ]
                        )
                    )
                )
            )
        );
        $url = $this->apiEndPoint."/profile?advertiser_id=".$this->advertiserId;
        echo "Create From Bucket\n".$url."\n";
        return $this->postData($data, $url);
    }

    

    protected function hydrate($data)
    {
        $this->id = $data->id;
        $this->code = $data->code;
        return $this;
    }

    /*
    public function updateFromBucket()
    {
        $data = array(
            "profile" => array(
                "code" => "hb_pb_".$this->bucket,
                "key_value_targets" => array(
                     "kv_expression" => array(
                        "header" => array(
                            "an_version" => "1.0",
                            "client_version" => "1.0"
                        ),
                        "exp" => array(
                            "typ" => "in",
                            "vtp" => "sta",
                            "key" => "hb_pb",
                            "vsa" => [$this->bucket]
                        )
                    )
                )
            )
        );
        return $this->postData($data, $this->apiEndPoint."/profile?code=."$this->code."&advertiser_code=".$this->advertiserCode);
    }
    */
    
}