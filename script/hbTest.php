<?php

require __DIR__ .'/../vendor/autoload.php';

$script = (new \App\Script\HbSetup)->setVersionName("PREBID_V0131")
	->setHeaderBidding();