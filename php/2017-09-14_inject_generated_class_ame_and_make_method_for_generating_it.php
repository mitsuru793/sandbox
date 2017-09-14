<?php
/*
生成するクラス名を注入して、生成処理だけをメソッド化する。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function run()
{
    $client = new ApiClient(XMLFormat::class);
    $response = $client->request1();
    assert($response->content === 'XML: response data');

    $response = $client->request2();
    assert($response->content === 'XML: response data');
}

class ApiClient
{
    private $responseFormatClass;

    public function __construct(string $responseFormatClass)
    {
        // 生成するクラス名を注入
        $this->responseFormatClass = $responseFormatClass;
    }

    public function request1()
    {
        // newを直接使う
        return new $this->responseFormatClass('response data');
    }

    public function request2()
    {
        // privateメソッドに代理する。
        // 継承クラスで、newの部分だけ上書きすることが可能にある。
        return $this->newResponse('response data');
    }

    protected function newResponse(string $content)
    {
        return new $this->responseFormatClass('response data');
    }
}

class XMLFormat
{
    public $content;

    public function __construct(string $content)
    {
        $this->content = "XML: $content";
    }
}

run();
