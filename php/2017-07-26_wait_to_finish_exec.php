<?php
/*
組み込み関数のexecはコマンドの実行が終わるまで、PHPスレッドを待機させる。
*/

echo '1';
wait(3);
echo '2';

function wait(int $second)
{
    exec("sleep $second;");
}
