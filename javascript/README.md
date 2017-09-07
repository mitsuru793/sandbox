# コードリスト

### 1ファイルでサーバを立てて、fetchでレンスポンスを取得する。
2017-08-05 [source](./2017-08-05_build_http_server_and_fetch_its_response_in_only_a_file.js)

### generatorでsetTimeoutを同期的に処理する。
2017-08-05 [source](./2017-08-05_deal_settimeout_synchrnously_with_generator.js)
参考: [generatorとJavaScriptの非同期処理 \- Qiita](http://qiita.com/hitsujiwool/items/316f3e8a41fb7dc3a119)

### Promiseでインクリメントする。
2017-08-05 [source](./2017-08-05_increment_with_promise.js)

### generatorでrangeを作り、偶数を抽出する。
2017-08-05 [source](./2017-08-05_make_range_and_filter_extract_odd_with_generator.js)

### setTimeoutを配列で管理して、同期させてシーケンシャルに実行する。
2017-08-05 [source](./2017-08-05_manage_settimeout_with_array_for_sequence.js)
前のsetTimeoutが実行された後に、次のsetTimeoutを実行する。
同時に全てをタイマーに登録させない。

### iteratorとSymbolで文字列の各文字をブラケットで囲んで出力
2017-08-05 [source](./2017-08-05_out_chars_surrounded_with_bracket_by_iterator_and_Symbol.js)
参考: [JavaScript の イテレータ を極める！ \- Qiita](http://qiita.com/kura07/items/cf168a7ea20e8c2554c6)

### formでsubmitする前にjqueryでsrializeArrayしてバリデートする
2017-08-06 [source](./2017-08-06_sealizeArray_of_jquery_form_to_validate_it_before_submit/index.html)
srializeArrayを連想配列に変換してからバリデート

### ランダムの時間、待機する。
2017-09-06 [source](./2017-09-06_wait_random_time.js)

### awaitの戻り値はresolve, rejectに渡した引数。
2017-09-07 [source](./2017-09-07_return_of_await_is_argument_passing_to_resolve_and_reject.js)