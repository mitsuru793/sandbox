<?php
/*
str_replaceでブラケットを変数とした超簡単テンプレートシステムを作る

{{NAME}}でテンプレートシステム用の変数となる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function render(string $subject, array $data): string
{
    $search = [];
    $replace = [];
    foreach ($data as $key => $val) {
        $search[] = '{{' . $key . '}}';
        $replace[] = $val;
    }
    return str_replace($search, $replace, $subject);
}

$template = <<<HTML
<p>{{NAME}}</p>
<p>{{AGE}}</p>

HTML;

$data = ['NAME' => 'mike', 'AGE' => 12];
$view = render($template, $data);
echo $view;
/*
<p>mike</p>
<p>12</p>
*/
