<?php
/*
フォームデータで、連想配列を使わずカラムごとにnameを分けて、サーバーサイドで連想配列にする。

`users[4][name]`ではなく、`user_names[4]`とする。
*/

require_once __DIR__ . '/vendor/autoload.php';

$selectedUsers = [];
foreach ($_POST['selectedIds'] ?? [] as $id) {
    $selectedUsers[$id] = [
        'name' => $_POST['user_names'][$id],
        'age' => $_POST['user_ages'][$id],
    ];
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
                        <input type="text" name="user_names[1]">
                    </td>
                    <td>
                        <input type="number" name="user_ages[1]">
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
                        <input type="text" name="user_names[4]">
                    </td>
                    <td>
                        <input type="number" name="user_ages[4]">
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="submit">
    </form>
</body>
</html>
