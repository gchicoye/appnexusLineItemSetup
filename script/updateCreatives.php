<?php

require __DIR__ .'/../vendor/autoload.php';

$params = array(
	"sizes" => [[300,600], [300,250], [320,50], [728, 90], [1,1]],
	"granularity" => "dense",
	"prefix" => "PREBID_BANNER",
	"format" => "banner"
);

$script = (new \App\Script\HbSetup)
	->setSizes($params['sizes'])
	->setPrefix($params['prefix'])
	->setCreatives();