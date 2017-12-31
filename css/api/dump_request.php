<?php

require_once __DIR__ . '/autoload.php';

function bufferDump(array $targets): array
{
    $buffers = [];
    foreach ($targets as $target) {
        ob_start();
        dump($target);
        $buffers[] = ob_get_clean();
    }
    return $buffers;
}

[$dumpedGet, $dumpedPost, $dumpedServer] = bufferDump([$_GET, $_POST, $_SERVER]);

echo <<<HTML
<p>
    <a href="{$_SERVER['HTTP_REFERER']}">前のページへ戻る</a>
</p>

<h1>フォーム送信のDump</h1>

<h2>GET</h2>
{$dumpedGet}

<h2>POST</h2>
${dumpedPost}

<h2>SERVER</h2>
{$dumpedServer}

<p>
    <a href="{$_SERVER['HTTP_REFERER']}">前のページへ戻る</a>
</p>
HTML;
