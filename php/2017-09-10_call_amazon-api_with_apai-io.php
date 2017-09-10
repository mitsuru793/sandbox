<?php
/*
apai-ioでamaozonのapiを叩く
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$client = new \GuzzleHttp\Client;
$request = new \ApaiIO\Request\GuzzleRequest($client);

$conf = (new GenericConfiguration)
    ->setCountry('co.jp')
    ->setAccessKey(getenv('AMAZON_ACCESS_KEY'))
    ->setSecretKey(getenv('AMAZON_SECRET_KEY'))
    ->setAssociateTag(getenv('AMAZON_ASSOCIATE_TAG'))
    ->setResponseTransformer(new \ApaiIO\ResponseTransformer\XmlToSimpleXmlObject)
    ->setRequest($request);
$apaiIO = new ApaiIO($conf);

$search = new Search;
$search->setCategory('DVD');
$search->setActor('Bruce Willis');
$search->setKeywords('Die Hard');

$formattedResponse = $apaiIO->runOperation($search);
dump($formattedResponse);
