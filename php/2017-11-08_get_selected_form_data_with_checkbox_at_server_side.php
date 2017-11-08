<?php
/*
サーバーサイドでcheckboxで選択した行のフォームデータのみを取得

checkbox以外は常にデータが送られるため、全てのデータからcheckした行のみを抽出する。
jsを使いクライアントで、先に抽出してcheckした行のみをPOSTしても良い。

`users[1][name]`とname属性のkeyにはレコードのidを使う。checkboxには`<input type="checkbox" name="selectedIds[]" value="1">`とレコードのidを入れる。checkboxは選択したユーザーのkeyになる。
*/

require_once __DIR__ . '/vendor/autoload.php';

$selectedUsers = [];
if (isset($_POST['selectedIds'])) {
    foreach ($_POST['selectedIds'] as $id) {
        $selectedUsers[$id] = $_POST['users'][$id];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <p>POST All Data</p>
    <? dump($_POST) ?>
    <p>POST Selected Users</p>
    <? dump($selectedUsers) ?>
    <form action="" method="post">
        <table>
            <thead>
                <tr>
                    <th>send</th>
                    <th>id</th>
                    <th>name</th>
                    <th>age</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="checkbox" name="selectedIds[]" value="1">
                    </td>
                    <td>
                        1
                    </td>
                    <td>
                        <input type="text" name="users[1][name]">
                    </td>
                    <td>
                        <input type="number" name="users[1][age]">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="selectedIds[]" value="4">
                    </td>
                    <td>
                        4
                    </td>
                    <td>
                        <input type="text" name="users[4][name]">
                    </td>
                    <td>
                        <input type="number" name="users[4][age]">
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="submit">
    </form>
</body>
</html>
