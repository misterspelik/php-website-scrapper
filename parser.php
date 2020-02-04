<?php

require_once './vendor/autoload.php';

use Scrapper\Scrapper;
use Scrapper\Cli\Input;

$domain = Input::getDomain();

$scrapper = Scrapper::getInstance();
$scrapper->setDomain($domain);

$scrapper->run();


$domain = 'https://soul-dance-studio-salsa-school.business.site';
$new_domain = 'http://salsaodessa.com';

parseWebsite($domain, $new_domain);