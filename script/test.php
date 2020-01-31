<?php

require __DIR__ .'/../vendor/autoload.php';

$authorization = (new App\Connexion\Connexion)->setCredentials()
	->renewToken()
	->getAuthorization();


$advertiser = (new App\Manager\Advertiser)
	->setAuthorization($authorization)
	->setName('TEST_PREBID_1')
	->setFromName();

$campaign = (new App\Manager\Campaign)
	->setAuthorization($authorization)
	->setName('TEST_PREBID_1')
	->setAdvertiserId($advertiser->getId())
	->setFromName();
exit; 

$creative = (new App\Manager\Creative)
	->setAuthorization($authorization)
	->setAdvertiserId($advertiser->getId())
	->setName('PREBID_CREATIVE_TEST_V1')
	->setSizeArray([300,250])
	->setFromName();

$profile =  (new App\Manager\Profile)
	->setAuthorization($authorization)
	->setBucket("0.10")
	->setAdvertiserId($advertiser->getId())
	->createFromBucket();
exit;

$profile = (new App\Manager\Profile)
	->setAuthorization($authorization)
	->setId("118259580")
	->getFromId();
var_dump($profile);
exit;

//"118259685"



$lineItem = (new App\Manager\LineItem)
	->setAuthorization($authorization)
	->setAdvertiserId($advertiser->getId())
	->getAllFromAdvertiserId();
var_dump($lineItem[0]);
exit;

$user = (new App\Manager\User)->setAuthorization($authorization)
	->getUser();






exit;
foreach ($creative->getAll() as $creative) {
	if($creative->type == "html"){
		echo json_encode($creative, JSON_PRETTY_PRINT);
	}
}
exit;





var_dump($advertiser);
exit;
/*
$insertionOrders = (new App\Manager\InsertionOrder)->setAuthorization($authorization)
	->setAdvertiser($advertiser)
	->getAllFromAdvertiser();
*/


$lineItems = (new App\Manager\LineItem)->setAuthorization($authorization)
	->setAdvertiser($advertiser)
	->getAllFromAdvertiser();
var_dump($lineItems[0]);

