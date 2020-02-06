<?php

namespace App\Manager;

class Creative extends Manager
{
	protected $id;
	protected $name = "";
	protected $advertiserId;
	protected $sizeArray;

	
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
    		"creative" => array(
    			"name" => $this->name,
    			"code" => $this->nameToCode(),
    			"advertiser_id" => $this->advertiserId,
    			"original_content" => $this->getOriginalContent(),
    			"content" => $this->getContent(),
    			"original_content_secure" => $this->getOriginalContent(),
    			"content_secure" => $this->getContent(),
    			"allow_audit" => false,
    			"allow_ssl_audit" => true,
    			"width" => $this->sizeArray[0],
    			"height" => $this->sizeArray[1],
    			"template" => array(
		            "id" => "6"
		        )
    		)
    	);
    	return $this->postData($data, $this->apiEndPoint."/creative?advertiser_id=".$this->advertiserId);
    }

    public function updateFromName()
    {
    	$data = array(
    		"creative" => array(
    			"id" => $this->id,
    			"name" => $this->name,
    			"code" => $this->nameToCode(),
    			"advertiser_id" => $this->advertiserId,
    			"original_content" => $this->getOriginalContent(),
    			"content" => $this->getContent(),
    			"original_content_secure" => $this->getOriginalContent(),
    			"content_secure" => $this->getContent(),
    			"allow_audit" => false,
    			"allow_ssl_audit" => true,
    			"width" => $this->sizeArray[0],
    			"height" => $this->sizeArray[1],
    			"template" => array(
		            "id" => "6"
		        )
    		)
    	);
    	return $this->putData($data, $this->apiEndPoint."/creative?id=".$this->id."&advertiser_id=".$this->advertiserId);
    }
	
	protected function hydrate($data)
	{
		
        $this->id = $data->id;
		$this->name = $data->name;
		return $this;
	}


	protected function getOriginalContent()
	{
		$output = "<script src = \\\"https://cdn.jsdelivr.net/npm/prebid-universal-creative@latest/dist/creative.js\\\"><\\/script>\\n<script>\\n  var ucTagData = {};\\n  ucTagData.adServerDomain = window.location.host;\\n  ucTagData.pubUrl = \\\"\${REFERER_URL_ENC}\\\";\\n  ucTagData.adId = \\\"#{HB_ADID}\\\";\\n  ucTagData.cacheHost = \\\"\\\";\\n  ucTagData.cachePath = \\\"\\\";\\n  ucTagData.uuid = \\\"\\\";\\n  ucTagData.mediaType = \\\"#{HB_FORMAT}\\\";\\n  ucTagData.env = \\\"\\\";\\n  ucTagData.size = \\\"#{HB_SIZE}\\\";\\n  ucTagData.hbPb = \\\"#{HB_PB}\\\";\\n  try {\\n    ucTag.renderAd(document, ucTagData);\\n  } catch (e) {\\n    console.log(e);\\n  }\\n<\\/script>";
		return $output;
	}

	protected function getContent()
	{
		$output =  "document.write('<script src = \\\"https://cdn.jsdelivr.net/npm/prebid-universal-creative@latest/dist/creative.js\\\"><\\/script>\\n<script>\\n  var ucTagData = {};\\n  ucTagData.adServerDomain = window.location.host;\\n  ucTagData.pubUrl = \\\"\${REFERER_URL_ENC}\\\";\\n  ucTagData.adId = \\\"#{HB_ADID}\\\";\\n  ucTagData.cacheHost = \\\"\\\";\\n  ucTagData.cachePath = \\\"\\\";\\n  ucTagData.uuid = \\\"\\\";\\n  ucTagData.mediaType = \\\"#{HB_FORMAT}\\\";\\n  ucTagData.env = \\\"\\\";\\n  ucTagData.size = \\\"#{HB_SIZE}\\\";\\n  ucTagData.hbPb = \\\"#{HB_PB}\\\";\\n  try {\\n    ucTag.renderAd(document, ucTagData);\\n  } catch (e) {\\n    console.log(e);\\n  }\\n<\\/script>');";

		return $output;
	}

}