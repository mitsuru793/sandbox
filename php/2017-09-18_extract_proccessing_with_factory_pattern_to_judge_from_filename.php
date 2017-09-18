<?php
/*
ファイル名を判断して出力する処理を、Factoryパターンで抽出する。

[PHPによるデザインパターン入門 \- Factory Method～生成処理と使用処理を分離する \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141215/1418620242)
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function run()
{
    // 使用者はファクトリにファイル名を入れてインスタンス化するだけ準備が整う。
    // ファイル名を判断する必要がない。
    $reader = (new ReaderFactory('hoge.csv'))->create();
    assert($reader instanceof CSVFileReader);
    $reader->read();
    assert('csv format result' === $reader->display());


    $reader = (new ReaderFactory('bar.xml'))->create();
    assert($reader instanceof XMLFileReader);
    $reader->read();
    assert('[xml format result]' === $reader->display());

    try {
        (new ReaderFactory('piyo.txt'))->create();
    } catch (RuntimeException $e) {
        assert('txt is not supported.' === $e->getMessage());
    }
}

// 完全コンストラクタにしたため、生成時にファイル名が検証される。
class ReaderFactory
{
    private $filename;

    public function __construct(string $filename)
    {
        $extensions = ['csv', 'xml'];
        preg_match('/\.([a-z]+)$/i', $filename, $matches);
        if (!in_array($matches[1] ?? '', $extensions)) {
            throw new RuntimeException("{$matches[1]} is not supported.");
        }
        $this->filename = $filename;
        $this->extention = $matches[1];
    }

    public function create() : Reader
    {
        $reader = $this->createReader();
        return $reader;
    }

    private function createReader() : Reader
    {
        switch ($this->extention) {
            case 'csv':
                return new CSVFileReader($this->filename);
            case 'xml':
                return new XMLFileReader($this->filename);
            default:
                // 他の修正で間違えてコンストラクタのバリデーションが
                // 削除されるかもしれないので念のため。
                throw new RuntimeException("{$this->extention} is not supported.");
        }
    }
}

interface Reader
{
    public function read() : void;
    // 実装クラスで同じ出力結果にする
    public function display() : string;
}

class CSVFileReader implements Reader
{
    private $filename;
    private $hanlder;

    public function __construct(string $filename)
    {
        // filenameが読み込み可能かの処理
        $this->filename = $filename;
    }

    public function read() : void
    {
        // fopenの代わり
        $content = new stdClass;
        $this->handler = $content;
    }

    public function display() : string
    {
        // $this->handlerを使い、CSVをliタグで出力するなど
        return 'csv format result';
    }
}

class XMLFileReader implements Reader
{
    private $filename;
    private $hanlder;

    public function __construct(string $filename)
    {
        // filenameが読み込み可能かの処理
        $this->filename = $filename;
    }

    public function read() : void
    {
        // simplexml_load_fileの代わり
        $content = new stdClass;
        $this->handler = $content;
    }

    public function display() : string
    {
        // $this->handlerを使い、XMLをliタグで出力するなど
        return $this->convert('xml format result');
    }

    // 出力を同じにするために必要な処理をprivateで定義できるのもメリット
    private function convert(string $str) : string
    {
        return "[{$str}]";
    }
}

run();
