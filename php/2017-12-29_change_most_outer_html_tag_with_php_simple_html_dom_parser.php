<?php
/*
一番外側のHTMLタグをphp-simple-html-dom-parserで変換する
*/

require_once __DIR__ . '/vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

$html = <<<HTML
<div class="wrapper">
    <div>
        <p>Hello</p>
    </div>
</div>
HTML;

$dom = HtmlDomParser::str_get_html($html);
$p =  $dom->firstChild();
dump($p->outertext);
dump($p->innertext);

$p->outertext = "<article>$p->innertext</article>";
dump($dom->save());
