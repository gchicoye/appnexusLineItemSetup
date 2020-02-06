<?php

require __DIR__ .'/../vendor/autoload.php';

$authorization = (new \App\Connexion\Connexion)->setCredentials()
			->renewToken()
			->getAuthorization();


$creative = (new App\Manager\Creative)
    ->setAuthorization($authorization)
    ->setId(206805168) //->setId(206358192) for test creative
    ->getFromId();
var_dump($creative);

