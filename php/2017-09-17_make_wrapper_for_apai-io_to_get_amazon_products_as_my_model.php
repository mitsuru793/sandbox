<?php
/*
amazonの商品データを自作モデルで簡単に取得できるように、apai-ioのラッパークラスを作る。

取得結果はSimpleXMLElementで複雑な構造のため、モデルクラスに入れる。
title, image, descriptionのみを持つ。
*/

require_once __DIR__ . '/vendor/autoload.php';

use ApaiIO\ApaiIO; use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\AbstractOperation;
use ApaiIO\Operations\Search;
use ApaiIO\Operations\Lookup;

use function Lib\puts;

function run()
{
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();

    // クロノクルセイド(新装版)(1) (ヤングキングコミックス)
    $url = 'https://www.amazon.co.jp/%E3%82%AF%E3%83%AD%E3%83%8E%E3%82%AF%E3%83%AB%E3%82%BB%E3%82%A4%E3%83%89-%E6%96%B0%E8%A3%85%E7%89%88-1-%E3%83%A4%E3%83%B3%E3%82%B0%E3%82%AD%E3%83%B3%E3%82%B0%E3%82%B3%E3%83%9F%E3%83%83%E3%82%AF%E3%82%B9-%E6%A3%AE%E5%B1%B1%E5%A4%A7%E8%BC%94-ebook/dp/B017LG9JRU/ref=sr_1_2?ie=UTF8&qid=1505101189&sr=8-2&keywords=%E3%82%AF%E3%83%AD%E3%83%8E%E3%82%AF%E3%83%AB%E3%82%BB%E3%82%A4%E3%83%89';
    $client = new AmazonClient('co.jp', PCAmazonData::class, 'JP');

    $amazonData = $client->findByUrl($url);
    dump($amazonData);

    $amazonDataList = $client->searchByKeyword('NARUTO');
    dump($amazonDataList);
}

// デバイスや場面ごとにスキーマを変更できるようにするために、
// データの生成はサブクラスのコンストラクタで行う。

abstract class AmazonData
{
    /**
     * @param array ItemAttributesの中でdescriptionとして使うデータ
     *     1つしか使用されず、先頭のものから探す。
     */
    private static $descriptionKey = [
        'Actor', 'Artist', 'Author', 'Brand', 'Label'
    ];

    abstract public function __construct(SimpleXMLElement $item, string $locale);

    /**
     * Itemから画像のハッシュ(id)を取得する。
     * @param SimpleXMLElement amazon apiのレスポンス パスは/Items/Item
     * @return ?string 画像のハッシュ。画像が存在しない場合はnullを返す。
     */
    protected function imageIdOfItem(SimpleXMLElement $item) : ?string
    {
        if (!isset($item->SmallImage)) {
            return null;
        }

        preg_match('~I\/([^_]+)\._S~', $item->SmallImage->URL, $match);
        return $match[1];
    }

    /**
     * Itemからdescriptionを生成する。
     * @param SimpleXMLElement amazon apiのレスポンス パスは/Items/Item
     * @return string 生成したdescription
     */
    protected function descriptionOfItem(SimpleXMLElement $item) : string
    {
        $desc = '';
        foreach (self::$descriptionKey as $key) {
            $atrribute = $item->ItemAttributes->$key ?? null;
            if (!is_null($atrribute)) {
                $desc = is_array($atrribute) ? implode(',', $atrribute) : (string)$atrribute;
                break;
            }
        }
        return $desc;
    }
}

class PCAmazonData extends AmazonData
{
    /**
     * @param SimpleXMLElement $item amazon apiのレスポンス パスは/Items/Item
     * @param string $locale
     */
    public function __construct(SimpleXMLElement $item, string $locale)
    {
        // https://forums.aws.amazon.com/thread.jspa?threadID=3587
        // ASINは全localeでユニークではないため、ローカルのlocaleをprifixでつけておく。
        $this->title = $locale . '_' . $item->ASIN;
        $this->title = (string)$item->ItemAttributes->Title;
        $this->image = $this->imageIdOfItem($item);
        $this->description = $this->descriptionOfItem($item);
    }
}

class AppAmazonData extends AmazonData
{
    /**
     * @param SimpleXMLElement $item amazon apiのレスポンス パスは/Items/Item
     */
    public function __construct(SimpleXMLElement $item, string $locale)
    {
        // アプリ用のデータ生成処理。
    }
}

class AmazonClient
{
    /** @var ApiIO $client */
    private $client;

    /** @var string $dataClass レスポンスのラッパークラスを指定できる。AmazonDataを継承。 */
    private $dataClass;

    /** @var string $asinPrefix AISNは全localeでユニークではないため、prefixをつけるようにしている。 */
    private $asinPrefix;

    public function __construct(string $country, string $dataClass, string $asinPrefix)
    {
        $this->client = $this->createClient($country);
        if ($dataClass instanceof AmazonData) {
        }
        $this->dataClass = $dataClass;
        $this->asinPrefix = $asinPrefix;
    }

    /**
     * 国ごとのAPIを叩くクライアントを生成
     *
     * @param string $country amazonのルートドメイン
     * @return ApaiIO
     */
    private function createClient(string $country) : ApaiIO
    {
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

    /**
     * $urlから商品データを1つ取得する。
     *
     * @param string $url 商品個別ページのURL
     * @return AmazonData /Items/Item
     */
    public function findByUrl(string $url) : ?AmazonData
    {
        // amazon apiでurlから商品IDを取得するものはなく、正規表現しか手段がない。
        $pattern = '~
        (?:dp|o|gp|product|ASIN|obidos-)/
        (B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(?:X|[0-9]))
        ~x';
        if (!preg_match($pattern, $url, $matches)) {
            return null;
        }
        return $this->findById($matches[1]);
    }

    /**
     * $idから商品データを1つ取得する。

     * @throws RequestThrottledException
     *
     * @param string $hash 商品のASIN
     * @return AmazonData /Items/Item
     */
    private function findById(string $id) : ?AmazonData
    {
        $lookup = new Lookup;
        $lookup->setItemId($id);
        $lookup->setResponseGroup(['ItemAttributes', 'Images']);
        $results = $this->requestItems($lookup);
        return empty($results) ? null : $this->newData($results[0]);
    }

    /**
     * キーワードで商品を検索する。
     *
     * @throws RequestThrottledException
     *
     * @param string $keyword 検索キーワード
     * @param string $category 検索カテゴリ。デフォルトはAll
     * @param int $page 取得する検索結果のページ。デフォルトは1
     * @return array 各要素は/Items/Item
     */
    public function searchByKeyword(string $keyword, string $category = 'All', int $page = 1) : array
    {
        $amazonSearch = (new Search)
            ->setCategory($category)
            ->setKeywords($keyword)
            ->setItemPage($page)
            // レスポンスに含める内容を追加する。
            ->setResponseGroup(['ItemAttributes', 'Images']);
        if ($category !== 'All') {
            $amazonSearch->setSort('salesrank');
        }

        $dataList = [];
        foreach ($this->requestItems($amazonSearch) as $item) {
            $data = $this->newData($item);
            if (is_null($data)) {
                continue;
            }
            $dataList[] = $data;
        }
        return $dataList;
    }

    /**
     * $operationに基づいて商品情報を取得する。
     *
     * @throws RequestThrottledException
     *
     * @param AbstractOperation $operation SearchやLookupなどの検索設定オブジェクト
     * @return SimpleXMLElement 各要素は/Items/Item
     */
    private function requestItems(AbstractOperation $operation) : SimpleXMLElement
    {
        try {
            $result = $this->client->runOperation($operation);
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            if ($e->getCode() === 503) {
                throw new RequestThrottledException;
            }
        }
        if (isset($result->Error) && (string)$result->Error->Code === 'RequestThrottled') {
            throw new RequestThrottledException;
        }
        if (empty($result->Items->Item)) {
            return [];
        }
        return $result->Items->Item;
    }

    /**
     * amazon apiのレスポンスから、Itemのdataオブジェクトを生成する。
     *
     * @param SimpleXMLElement $item amazon apiのレスポンス パスは/Items/Item
     * @param bool $filterAdult アダルト商品は生成しない。デフォルトはtrue。
     * @return ?AmazonData
     */
    private function newData(SimpleXMLElement $item, bool $filterAdult = true) : ?AmazonData
    {
        if ($filterAdult && ($item->ItemAttributes->IsAdultProduct ?? null) === 1) {
            return null;
        }
        $data = new $this->dataClass($item, $this->asinPrefix);
        return $data;
    }
}

class RequestThrottledException extends Exception
{
    public function __construct() {
        parent::__construct('Request is Throttled');
    }
}

run();
