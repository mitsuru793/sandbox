<?php
/*
apai-ioのbuilderクラスを作る
*/

require_once __DIR__ . '/vendor/autoload.php';

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;
use function Lib\puts;

class AamazonClientBuilder
{
    public static function create(string $country)
    {
        $dotenv = new Dotenv\Dotenv(__DIR__);
        $dotenv->load();

        $client = new \GuzzleHttp\Client;
        $request = new \ApaiIO\Request\GuzzleRequest($client);

        $conf = (new GenericConfiguration)
            ->setCountry($country)
            ->setAccessKey(getenv('AMAZON_ACCESS_KEY'))
            ->setSecretKey(getenv('AMAZON_SECRET_KEY'))
            ->setAssociateTag(getenv('AMAZON_ASSOCIATE_TAG'))
            ->setResponseTransformer(new \ApaiIO\ResponseTransformer\XmlToSimpleXmlObject)
            ->setRequest($request);
        return new ApaiIO($conf);
    }
}

assert(AamazonClientBuilder::create('co.jp') instanceof ApaiIO);
