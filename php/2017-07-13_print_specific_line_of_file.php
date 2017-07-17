<?
/*
ファイルの特定行を表示
*/

function main()
{
    $prifix = time() . '_php';
    $path = makeTmpFile($prifix);
    $acutual = rtrim(lineOfFile($path, 2));

    assert($acutual === '2 value');

    // ファイルを削除
    unlink($path);
}

/**
 * $fileの$num行目を取得する。
 * $num行目までしか読み込まない。
 */
function lineOfFile(string $file, int $num) : string
{
    $handle = fopen($file, 'r');
    if (!$handle) {
        throw new RuntimeException("Fail open file: {$file}.");
    }
    for ($i = 0; $i < $num; $i++) {
        $last = fgets($handle);
    }
    return $last;
}

/**
 * $prifixを接頭辞としたユニークなファイルを/tmpに作成する。
 */
function makeTmpFile(string $prifix) : string
{
    $content = <<<EOD
1 value
2 value
3 value
EOD;
    // prifixがphpのユニークなファイルを/tmpに作成する。
    $path = tempnam('/tmp', $prifix);
    file_put_contents($path, $content);
    return $path;
}

main();
