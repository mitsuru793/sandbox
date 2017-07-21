<?php
/*
画像が存在するかをcurl関数で確認する。
*/

// Twitterのデフォルトのアイコン画像
$successUrl = 'https://abs.twimg.com/sticky/default_profile_images/default_profile_400x400.png';
// 上記のサイズの部分を、存在しないものに変更。
$failUrl = 'https://abs.twimg.com/sticky/default_profile_images/default_profile_999x999.png';

assert(getHttpCode($successUrl) === 200);
assert(getHttpCode($failUrl) === 404);

function getHttpCode(string $url) : int
{
    $ch = curl_init($url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return $info['http_code'];
}
