<?php
/*
テーブルの各行のカラム値を配列で送信(form)する。

配列で取得できるとModelを通じて登録するのが便利。
*/

require_once __DIR__ . '/vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <? dump($_POST) ?>
    <form action="" method="post">
        <table>
            <thead>
                <tr>
                    <th>name</th>
                    <th>age</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="text" name="users[0][name]">
                    </td>
                    <td>
                        <input type="number" name="users[0][age]">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="users[1][name]">
                    </td>
                    <td>
                        <input type="number" name="users[1][age]">
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="submit">
    </form>
</body>
</html>
