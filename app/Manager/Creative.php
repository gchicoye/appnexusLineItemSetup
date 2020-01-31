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
		$output = "";
		$output .= "<script src = \"https://cdn.jsdelivr.net/npm/prebid-universal-creative@latest/dist/creative.js\"></script>\n";
		$output .= "<script>\n";
		$output .= "  var ucTagData = {};\n";
		$output .= "  ucTagData.adServerDomain = window.location.host;\n";
		$output .= "  ucTagData.pubUrl = \"\${REFERER_URL_ENC}\";\n";
		$output .= "  ucTagData.adId = \"#{HB_ADID}\";\n";
		$output .= "  ucTagData.cacheHost = \"\";\n";
		$output .= "  ucTagData.cachePath = \"\";\n";
		$output .= "  ucTagData.uuid = \"\";\n";
		$output .= "  ucTagData.mediaType = \"#{HB_FORMAT}\";\n";
		$output .= "  ucTagData.env = \"\";\n";
		$output .= "  ucTagData.size = \"#{HB_SIZE}\";\n";
		$output .= "  ucTagData.hbPb = \"#{HB_PB}\";\n";
		$output .= "  try {\n";
		$output .= "    ucTag.renderAd(document, ucTagData);\n";
		$output .= "  } catch (e) {\n";
		$output .= "    console.log(e);\n";
		$output .= "  }\n";
		$output .= "</script>\n";
		
		return $output;
	}

	protected function getContent()
	{
		$output = "";
		$script = $this->getOriginalContent();
		$script = str_replace("\\", "\\\\", $script);
		$script = str_replace("script", "scr\"+\"ipt", $script);
		$script = str_replace("\n", "", $script);		
		
		$output = "document.write(\"";
		$output .= $script;
		$output .= "\")";

		return $output;
	}

}