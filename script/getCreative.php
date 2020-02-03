<?php

require __DIR__ .'/../vendor/autoload.php';

$authorization = (new \App\Connexion\Connexion)->setCredentials()
			->renewToken()
			->getAuthorization();

/*
$LineItem = (new App\Manager\LineItem)
	->setAuthorization($authorization)
	->setId(10653738)
	->getFromId();
//var_dump($creative);
*/

$profile = (new App\Manager\Profile)
	->setAuthorization($authorization)
	->setId(118269573)
	->getFromId();


var_dump($profile);