<?php
/*
AmazonのURLから商品IDを取得する。

APIでURLからIDは取得できない。正規表現で解析するしかない。

+ [php \- Get ASIN from pasted Amazon url \- Stack Overflow](https://stackoverflow.com/questions/21700573/get-asin-from-pasted-amazon-url)
+ [Amazonの商品ページURLフォーマットに関するメモ \- Qiita](http://qiita.com/Feburic/items/6e918b1a9345367622c9)
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$urls = [
    // クロノクルセイド 1 (ヤングキングコミックス) コミックス
    // ISBN 本だけに使われる。
    // /<商品タイトル>/dp/4785932910/ref=tmm_other_meta_binding_swatch_0?_encoding=UTF8&qid=1505101381&sr=8-2';
    'https://www.amazon.co.jp/%E3%82%AF%E3%83%AD%E3%83%8E%E3%82%AF%E3%83%AB%E3%82%BB%E3%82%A4%E3%83%89-1-%E3%83%A4%E3%83%B3%E3%82%B0%E3%82%AD%E3%83%B3%E3%82%B0%E3%82%B3%E3%83%9F%E3%83%83%E3%82%AF%E3%82%B9-%E6%A3%AE%E5%B1%B1-%E5%A4%A7%E8%BC%94/dp/4785932910/ref=tmm_other_meta_binding_swatch_0?_encoding=UTF8&qid=1505101381&sr=8-2'
    => '4785932910',

    // クロノクルセイド 1 (ヤングキングコミックス) Kindle版
    // ASBN Bから始まる。
    'https://www.amazon.co.jp/%E3%82%AF%E3%83%AD%E3%83%8E%E3%82%AF%E3%83%AB%E3%82%BB%E3%82%A4%E3%83%89-%E6%96%B0%E8%A3%85%E7%89%88-1-%E3%83%A4%E3%83%B3%E3%82%B0%E3%82%AD%E3%83%B3%E3%82%B0%E3%82%B3%E3%83%9F%E3%83%83%E3%82%AF%E3%82%B9-%E6%A3%AE%E5%B1%B1%E5%A4%A7%E8%BC%94-ebook/dp/B017LG9JRU/ref=tmm_kin_swatch_0?_encoding=UTF8&qid=1505101381&sr=8-2'
    => 'B017LG9JRU',

    // Nikon デジタルカメラ COOLPIX S7000 20倍ズーム 1605万画素 ゴールド S7000GL
    // 最新版
    'https://www.amazon.co.jp/gp/product/B00TEY2W72/'
    => 'B00TEY2W72',

    // 上記の古いやつ
    'https://www.amazon.co.jp/exec/obidos/ASIN/B00TEY2W72/'
    => 'B00TEY2W72',

    // 上記の短縮版
    'https://www.amazon.co.jp/o/ASIN/B00TEY2W72/'
    => 'B00TEY2W72',

    // 上記のGoogle等の検索エンジンからの流入用URLのフォーマット
    // /dpの前に好きな文字が挟み込める。グーグルの検索結果のタイトルが挟まれる。
    'https://www.amazon.co.jp/%E3%83%87%E3%82%B8%E3%82%BF%E3%83%AB%E3%82%AB%E3%83%A1%E3%83%A9-COO-1605%E4%B8%87%E7%94%BB%E7%B4%A0-S7000GL/dp/B00TEY2W72'
    => 'B00TEY2W72',
    'https://www.amazon.co.jp/dp/B00TEY2W72'
    => 'B00TEY2W72',
];

foreach ($urls as $url => $id) {
    preg_match('~
    (?:dp|o|gp|product|ASIN|obidos-)/
    (B[0-9]{2}[0-9A-Z]{7}|[0-9]{9}(?:X|[0-9]))
    ~x', $url, $matches);
    assert($matches[1] === $id);
    dump($matches);
}
