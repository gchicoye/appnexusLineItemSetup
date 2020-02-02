<?php

require __DIR__ .'/../vendor/autoload.php';

$authorization = (new App\Connexion\Connexion)->setCredentials()
	->renewToken()
	->getAuthorization();

var_dump($authorization);
