<?php

namespace App\Script;

class HbSetup
{
	protected $authorization;

	protected $sizes = [[300,600], [300,250], [320,50]];

	protected $granularity = "auto";

	protected $prefix = "PREBIDV3";

	public function __call($m,$p)
	{     
        $v = lcfirst(substr($m,3));
        if (!strncasecmp($m,'get',3))return $this->$v;
        if (!strncasecmp($m,'set',3)){
        	$this->$v = $p[0];
        	return $this;
        }
    }


	public function __construct()
	{
		$this->authorization = (new \App\Connexion\Connexion)->setCredentials()
			->renewToken()
			->getAuthorization();
	}

	public function setHeaderBidding()
	{
		$user = (new \App\Manager\User)->setAuthorization($this->authorization)
			->getUser();

		$advertiser = (new \App\Manager\Advertiser)
			->setAuthorization($this->authorization)
			->setName($this->prefix)
			->setFromName();

		$insertionOrder = (new \App\Manager\InsertionOrder)
			->setAuthorization($this->authorization)
			->setName($this->prefix)
			->setAdvertiserId($advertiser->getId())
			->setFromName();

		$creatives = []; 
		foreach ($this->sizes as $sizeArray) {
			$creative = (new \App\Manager\Creative)
				->setAuthorization($this->authorization)
				->setAdvertiserId($advertiser->getId())
				->setName($this->prefix."_".$sizeArray[0]."x".$sizeArray[1])
				->setSizeArray($sizeArray)
				->setFromName();
			array_push($creatives, $creative);
		}

		$buckets = \App\Tools\Buckets::createBuckets($this->granularity);

		foreach ($buckets as $bucket) {

			$name = $this->prefix."_".$bucket;
			$profile = (new \App\Manager\Profile)
				->setAuthorization($this->authorization)
				->setBucket($bucket)
				->setName($name)
				->setAdvertiserCode($advertiser->getCode())
				->setFromBucket();


			$lineItem = (new \App\Manager\LineItem)
				->setAuthorization($this->authorization)
				->setAdvertiserId($advertiser->getId())
				->setCreatives($creatives)
				->setProfileId($profile->getId())
				->setName($name)
				->setFromName();
			
			$campaign = (new \App\Manager\Campaign)
				->setAuthorization($this->authorization)
				->setAdvertiserId($advertiser->getId())
				->setName($name)
				->setLineItemId($lineItem->getId())
				->setFromName();

		}
	}
}
