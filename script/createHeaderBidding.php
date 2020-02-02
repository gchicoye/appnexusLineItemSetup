<?php

require __DIR__ .'/../vendor/autoload.php';

$params = array(
	"sizes" => [[300,600], [300,250], [320,50]],
	"granularity" => "auto",
	"prefix" => "PREBID_V0202"
);

$script = (new \App\Script\HbSetup)
	->setSizes($params['sizes'])
	->setGranularity($params['granularity'])
	->setPrefix($params['prefix'])
	->setHeaderBidding();