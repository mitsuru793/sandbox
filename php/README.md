# コードリスト

### インスタンスからクラスメソッドを呼び出せるが、インスタンスメソッドをクラスメソッドとしては呼び出すのは非推奨。
2017-07-13 [source](./2017-07-13_can_call_class_method_from_instance.php)

### コンストラクタはオーバーライドする時にシグネチャを変更できる。
2017-07-13 [source](./2017-07-13_can_change_signature_of_construct.php)

### `get_object_vars($this)`で子クラスのprivateプロパティだけは取得できない。
2017-07-13 [source](./2017-07-13_cannot_get_private_property_of_child.php)

### 引数の型にnullableを指定しても、省略はできない。
2017-07-13 [source](./2017-07-13_cannot_omit_arg_of_nullable_typehint.php)
省略する場合はデフォルト値を指定する。nullでなくてもいい。

### ファイルの特定行を表示
2017-07-13 [source](./2017-07-13_print_specific_line_of_file.php)

### stdClassも自作クラスもis_objectの判定はtrueである。
2017-07-13 [source](./2017-07-13_std_and_my_class_are_object.php)

### タイプヒントを子クラスで上書きすることはできない
2017-07-13 [source](./2017-07-13_use_interface_instead_of_child_class.php)

### null合体演算子は未定義なプロパティに使える。
2017-07-14 [source](./2017-07-14_can_use_null_coalesce_operator_to_undefined_property.php)

### 同名のクラス・インスタンス変数は定義する場合は、Noticeをもみ消す。
2017-07-14 [source](./2017-07-14_define_same_name_as_class_and_instance_variable.php)
インスタンス変数がない場合は、同名のクラス変数がないかを探す。
$o::$static_propという方法でアクセスも出来るが、共用変数なのでどのインスタンスから見ても同じ。
わざわざクラス変数からアクセスする必要はない。

### 三項演算子の戻り値にメソッドチェーンにする。
2017-07-14 [source](./2017-07-14_make_ternary_operator_method_chain.php)
()で囲めばwithは必要ないが、読みやすさを考慮しているかもしれない。

### PHPファイルの先頭のコメントブロックを解析して、タイトルと詳細の目次をMarkdownで出力する。
2017-07-17 [source](./2017-07-17_convert_front_php_comment_block_to_list_of_markdown.php)
コメントは複数行のスターで書く。
１行目にタイトル、以降に詳細分を記述する。

```
script a.php b.php
=>
### a.php
[souce](./a.php)

### b.php
source(./b.php)
説明です。
```

### インスタンスにクラスメソッドを呼び出しても、__callStaticは呼ばれない。
2017-07-17 [source](./2017-07-17_not_call_callStatic_when_a_instance_calls_class_method.php)

### ファイル名の先頭に今日の日付をつけて、タイトルを変える。拡張子は変更しない。
2017-07-17 [source](./2017-07-17_rename_to_add_prifix_today_and_title.php)
```
script tmp.php hello world
tmp.php -> 2017-07-17_hello_world.php
```

### compactに変数名を渡すと、[変数名 => 変数値]に変換する。
2017-07-17 [source](./2017-07-17_use_compact.php)

### laravelのCollection->eachでcontinue, breakするにはreturnとfalseを使う。
2017-07-17 [source](./2017-07-17_use_return_and_false_to_continue_and_break_for_laravel_collection.php)

### array_mapでreturnを書かない場合は、nullが入る。
2017-07-18 [source](./2017-07-18_array_map_insert_null_when_no_return.php)

### Eloquentでテーブルを作り、レコードを挿入する。
2017-07-18 [source](./2017-07-18_create_table_and_insert_records_with_eloquent.php)

### laravelのEloquentでカスタムコレクションを作る。
2017-07-18 [source](./2017-07-18_make_eloquent_custom_collection.php)

### Eloquentでテーブル名と違う名前でモデルを作り、関連テーブルから参照する。
2017-07-18 [source](./2017-07-18_refer_model_being_different_from_table_name_with_eloquent.php)

### debug_backtraceで呼び出し元の関数を特定する。
2017-07-18 [source](./2017-07-18_specify_caller_function_with_debug_backtrace.php)

### EloquentのローカルスコープはwhereHasのクロージャの中でも使える。
2017-07-18 [source](./2017-07-18_use_local_scope_of_eloquent_in_wherehas.php)

### underscore.phpのクラスメソッドを呼び出している部分を正規表現で抽出する
2017-07-19 [source](./2017-07-19_extract_calller_as_class_method_of_underscore_with_regexp.php)
`__::pluck($people, 'name');`

### __callStaticを定義していても、インスタンスメソッドをクラスメソッドとして呼び出すと警告される。
2017-07-19 [source](./2017-07-19_warn_even_if_define_callStatic_when_call_class_method_as_instance.php)

### EloquentのconfigのcharsetはSET NAMESの代わりになる。
2017-07-20 [source](./2017-07-20_config_of_eloquent_use_as_set_names.php)
[MySQL :: MySQL 5\.6 リファレンスマニュアル :: 10\.1\.4 接続文字セットおよび照合順序](https://dev.mysql.com/doc/refman/5.6/ja/charset-connection.html)

### Stringyにputsメソッドを追加する。
2017-07-21 [source](./2017-07-21_add_puts_method_to_Stringy.php)
[danielstjules/Stringy: A PHP string manipulation library with multibyte support](https://github.com/danielstjules/Stringy)

### 画像が存在するかをcurl関数で確認する。
2017-07-21 [source](./2017-07-21_confirm_if_image_exists_with_curl_function.php)

### gitで管理しているファイルを拡張子ごとに、ファイル数と行数を表示する。
2017-07-21 [source](./2017-07-21_list_total_number_of_files_and_lines_each_extension_tracked_by_git.php)
ステージングにあるファイルもカウントされる。
小さなスクリプトを書くには、下記を拡張すると良い。
[sebastianbergmann/git: Simple PHP wrapper for Git](https://github.com/sebastianbergmann/git)

### 改行をつけるecho、puts関数を作る。
2017-07-21 [source](./2017-07-21_make_puts_function.php)
ライブラリとしてローカルに置いておくと便利です。インデントもつけれます。

### 配列の要素である数値にインクリメント、代入演算子が使える。
2017-07-21 [source](./2017-07-21_use_increment_and_assignment_operator_to_number_of_array.php)

### anatoo/fnparse.jsをPHPで書き直す
2017-07-22 [source](./2017-07-22_rewrite_js_library_anatoo_fnparse.php)
[anatoo/fnparse\.js: An extremely simple parser combinator for JavaScript\.](https://github.com/anatoo/fnparse.js)

### ステージングを変更せずに、対象のファイルを1つだけをコミットする。
2017-07-23 [source](./2017-07-23_commit_one_file_without_changing_stage.php)
`php script.php README.md 'first commit'`

### nikic/PHP-Parserで特定のNodeを集めるVisitorを作成する。
2017-07-23 [source](./2017-07-23_make_collect_node_with_only_one_visitor_of_php_parser.php)
集めるNodeごとにVisitorを作る必要がなくなる。

### composerでインストールした各ライブラリのディレクトリサイズをソートして表示。
2017-07-23 [source](./2017-07-23_sort_and_display_size_of_directory_of_library_is_installed_by_composer.php)
下記を使ってみる。
[symfony/finder: \[READ\-ONLY\] Subtree split of the Symfony Finder Component](https://github.com/symfony/finder)

### SymfonyのVaridationはクラスの他に、スカラ値も検証できる。
2017-07-23 [source](./2017-07-23_symfony_can_validate_class_and_scala.php)
クラスにルールを追加するには、クラスメソッド、アノテーション、YAML、XMLがある。

### in_arrayを使うより、連想配列にissetを使うほうが18倍速い。
2017-07-24 [source](./2017-07-24_associative_array_is_18_times_faster_than_in_array.php)

### laravelのcollectionのHigher Order Messageで、ゲッターを通して集めた値にフィルタリングをかける。
2017-07-24 [source](./2017-07-24_filter_values_that_collected_by_heigher_order_message_of_laravel.php)

### 配列の結合にarray_mergeを使うと、添字が壊れる時は+を使うと良いこともある。
2017-07-25 [source](./2017-07-25_plus_mark_keeps_array_index.php.php)
+を使うと重複したkeyの値は上書きされない。添字を維持するarray_mergeのような関数はない？

配列のkeyにid(数字)を使っている時にarray_mergeを使うと、0から振り直されるため+をつかう。
idはユニークのため、+で重複を許さないのも有効である。

### PDOのメソッドをEloquentで代用する。
2017-07-25 [source](./2017-07-25_use_eloquent_instead_of_pdo.php)
Eloquentのメソッドを使うとデバッグのログが取れるのが良い。
だがgetPdoを使うのが速い。

### twitter apiを"abraham/twitteroauth"で叩く
2017-07-26 [source](./2017-07-26_call_tweet_api_with_abraham_twitterauth.php)

### composer requireしてコミットする。
2017-07-26 [source](./2017-07-26_compoesr_require_and_commit.php)
`php script 'person/libname'`

### laravelで取得したレコードの値を全て文字列に変換する。
2017-07-26 [source](./2017-07-26_conwert_all_values_of_recorad_to_string_in_laravel.php)

### puts関数を複数行の場合のインデントに対応する。
2017-07-26 [source](./2017-07-26_puts_function_makes_indent_for_multi_line.php)
1行目しかインデントに対応できていなかった。

### ===は配列の中身を再帰的に比較する
2017-07-26 [source](./2017-07-26_strict_equal_operator_compares_array_recursively.php)

### 組み込み関数のexecはコマンドの実行が終わるまで、PHPスレッドを待機させる。
2017-07-26 [source](./2017-07-26_wait_to_finish_exec.php)

### mysqlのログファイルで、ATTR_EMULATE_PREPARESが無効の時は2回DBにアクセスすることを確かめる。
2017-07-28 [source](./2017-07-28_confirm_2_access_to_db_with_log_file_of_mysql_when_atrr_emulate_prepares_is_false.php)
bindValueは実行するだけで、mysqlのログファイルに書き込まれます。

### laravelのDBManagerの起動は、通常のPDOの生成より4~10倍かかる。
2017-07-28 [source](./2017-07-28_laravel_database_bootstrap_take_from_4_to_10_times_than_raw_pdo.php)
Laravelのは2度目以降の起動はPHPスクリプトを一度終わらせる必要がある？
1つのスクリプト内でループさせてテストはできなさそう。

### 関数の実行時間を測るグローバル関数を作る
2017-07-28 [source](./2017-07-28_make_global_function_to_calc_exec_function_time.php)

### microtimeは秒単位で返す。小数はマイクロ秒単位まで持つという意味。
2017-08-01 [source](./2017-08-01_microtime_have_until_micro_and_second_unit.php)

### popenを使い、外部スクリプトの出力を終わるまで待たずに出力する。
2017-08-01 [source](./2017-08-01_output_without_waiting_to_finish_external_script.php)
仕組みは分かっていない。

### リポジトリクラスにEloquentとPDOを混在させて、モデルに変換させて取得する。
2017-08-02 [source](./2017-08-02_repository_use_eloquent_and_pdo_to_convert_model_to_get_it.php)
参考: https://github.com/shin1x1/laravel-ddd-sample

### adamwathan/formのモデルへのbindを、複数モデルに対応させる。
2017-08-04 [source](./2017-08-04_adapt_model_bind_of_adamwathan-form_to_multiple_models.php)
inputのname属性には`user[0][name]`とは書けないため、`name[]`と書く。
レコードのカラム値以外の値が混ざると対応できない。

### カラムごとにレコードの要素がある配列を、1レコード1要素に変換する。
2017-08-04 [source](./2017-08-04_convert_array_has_record_value_each_column_to_1_record_each_1_element.php)
formのinputで`users[0][name]`ではなく`name[]`としか書けない場合を想定

```
['name' => ['Adrain Cruickshank', ...], 'age' => [33, ...]]
[['name' => ['Adrain Cruickshank'], 'age' => 33], ...]
```

### テーブルの各行のカラム値を配列で送信(form)する。
2017-08-04 [source](./2017-08-04_submit_column_value_each_table_row_with_form.php)
配列で取得できるとModelを通じて登録するのが便利。

### pathがファイル・ディレクトリによってエントリーポイントを判断するクラスを作る。
2017-08-06 [source](./2017-08-06_make_a_class_that_detect_entry_point_from_either_file_or_directory.php)

### Valueオブジェクトの抽象クラスを作る
2017-08-06 [source](./2017-08-06_make_abstruct_value_class.php)
同じstringでも、Text, Nameとラップして型を示す事が可能。
メソッドを持たせることも出来る。
ValueObject::of($value)としか生成させないようにして、見分けをつける。

### __setは内部メソッドの中でも適用される。
2017-08-07 [source](./2017-08-07___set_applies_inside_method.php)

### laravelのCollection->keyByでidで要素を取得できるようにする。
2017-08-08 [source](./2017-08-08_get_element_by_id_with_collection_keyby_method_of_laravel.php)
検索値は連想配列のkeyにすると速い。

### クラスプロパティconstは、子クラスで上書きできる。
2017-08-09 [source](./2017-08-09_class_property_const_can_be_overriden.php)

### インスタンスメソッドと同名をクラスメソッドとして呼び出すと、__callStaticを定義してもDeprecatedになる。
2017-08-09 [source](./2017-08-09_instance_method_is_deprecated_to_call_as_static_even_if_define_callStatic.php)

### LSTVのアクセスログから、BOT以外のリクエストパスとユーザーエージェントのペアを取り出す。
2017-08-09 [source](./2017-08-09_take_pair_of_request_path_and_user_agent_except_bot_from_ltsv_of_acceess_log.php)

### セッションファイルにシリアライズされたデータを確認する
2017-08-10 [source](./2017-08-10_confirm_data_serialized_into_session_file.php)

### 許容されたオプションのみをセットする場合は、array_flipを使うと速い。
2017-08-10 [source](./2017-08-10_its_firster_to_set_only_valid_option_when_use_array_flip.php)

### オブジェクトのプロパティの更新に間隔を設けて制限する
2017-08-10 [source](./2017-08-10_limit_interval_to_update_property_of_object.php)

### 公開するプロパティと非公開のメタデータを、どちらもprotectedプロパティで管理する。
2017-08-10 [source](./2017-08-10_manage_both_published_property_and_not_one_with_protected_property.php)
`__set`を通して、publicプロパティとしてアクセスしてもセッターを呼び出すことが出来る。
jsonで書き出す時は$dataのみを対象とすれば良いので楽。

### laravelのcollectにはarrayだけでなく、Collectionを混ぜても良い。
2017-08-10 [source](./2017-08-10_mix_Collection_and_array_in_collect_of_laravel.php)

### SymfonyのSessionクラスを使ってみる。
2017-08-11 [source](./2017-08-11_use_session_class_of_symfony.php)
実装を見たところ、`$_SESSION`のラッパークラスという感じ。
Flush(FlushBag)とそれ以外(AttributeBag)は別々のクラス管理している。

### モデルをjson_encodeに渡せるようにする。
2017-08-29 [source](./2017-08-29_make_model_passed_to_json_encode.php)

### 配列のkeyをリネームする
2017-08-29 [source](./2017-08-29_rename_key_of_array.php)

### 末尾に/が無いと、parse_urlの結果にpathも無くなる。
2017-08-29 [source](./2017-08-29_result_of_parse_url_has_no_path_if_url_has_no_slash_at_the_end.php)

### get_class_methodsはインスタンスとクラスメソッドの両方を返す。
2017-09-02 [source](./2017-09-02_get_class_methods_returns_both_instance_and_class_methods.php)

### 戻り値にvoidを渡すと、明示的にnullをreturnできなくなる。
2017-09-02 [source](./2017-09-02_it_cannot_return_explicitly_when_set_return_type_as_void.php)
空のreturnもnullが返るが、厳密には違うようだ。

### ErrorとExceptinのメソッドは同じ
2017-09-02 [source](./2017-09-02_methods_of_error_and_exception_are_same.php)

### tightenco/collectのArr::collapseを読む
2017-09-02 [source](./2017-09-02_read_code_of_collapse_method_of_Arr_of_tightenco_collect.php)

### dot記法を実現するヘルパー関数data_getを読む
2017-09-02 [source](./2017-09-02_read_code_of_data_get.php)

### 関数内ではglobal変数は再定義しないとundefinedになる。
2017-09-04 [source](./2017-09-04_global_variable_will_be_undefined_when_not_defined_again_inside_function.php)

### mixedな値をラップして、1つの型に変換すると使いやすくなる。
2017-09-09 [source](./2017-09-09_easy_to_use_mixed_value_by_wrapping_and_cast.php)
StringyやCollectionを参考
mixedの値をコンストラクタで1つの型に変換すると使いやすくなる。
例外も自分で用意すれば、動的言語の良さを活かすことができる。
戻り値は固定した方がよいと思う。タイプヒントをつけよう。

### apai-ioでamaozonのapiを叩く
2017-09-10 [source](./2017-09-10_call_amazon-api_with_apai-io.php)

### interfaceにマジックメソッドも定義できるため、Commandパターンでexecuteの代わりにinvokeが使える。
2017-09-10 [source](./2017-09-10_can_use_invoke_method_instead_of_execute_in_command_pattern.php)
分かりづらい気もするので、メソッド名はexecuteの方がいいかも。
インターフェースで統一は出来ているので。

### Bridgeパターンで機能と実装を分けてクラスを実装する
2017-09-10 [source](./2017-09-10_implement_class_dividing_function_and_implementation.php)
[PHPによるデザインパターン入門 \- Bridge～実装と機能の架け橋 \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141216/1418705115)

機能クラスはファサードに近い感じがする。実装は別クラスに委譲しており、実装の最上位はインターフェースを使うとテンプレートメソッドになる。

### 委譲を使ったアダプタークラスを作る
2017-09-10 [source](./2017-09-10_make_adapter_class_transfering.php)
[PHPによるデザインパターン入門 \- Adapter～APIを変更する \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141212/1418364494)

既に実用していてバグがないことをが保証されているクラスのソースコードに一切手を加えずに、APIを変更できる。
委譲ではなく継承だと、古いAPIを隠すことができない。

### apai-ioのbuilderクラスを作る
2017-09-10 [source](./2017-09-10_make_apai-io_builder.php)

### 記事の承認ステータスをStateパターンで表現する。
2017-09-10 [source](./2017-09-10_represent_approve_state_of_article_with_state_pattern.php)
[PHPによるデザインパターン入門 \- State～状態を表す \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141219/1418965549)

nextStateは一方向でしか使えない。状態が分岐する場合には使えない。

### AmazonのURLから商品IDを取得する。
2017-09-11 [source](./2017-09-11_get_product_id_from_amazon_url.php)
APIでURLからIDは取得できない。正規表現で解析するしかない。

+ [php \- Get ASIN from pasted Amazon url \- Stack Overflow](https://stackoverflow.com/questions/21700573/get-asin-from-pasted-amazon-url)
+ [Amazonの商品ページURLフォーマットに関するメモ \- Qiita](http://qiita.com/Feburic/items/6e918b1a9345367622c9)

### json_encodeで__toStringは呼ばれない
2017-09-13 [source](./2017-09-13_not_call_toString_in_json_encode.php)
新しく中身をstringにキャストしながら、配列を作り直すかJsonSerializableを実装しておく。

### laravelのCollectionは、配列のkey名を維持する。
2017-09-13 [source](./2017-09-13_tightenco_collect_maintains_key_name_of_array.php)
keyに数字が使われている場合は、数値に変わる。

### 配列とstdClassを相互に再帰的に変換する関数を作る
2017-09-14 [source](./2017-09-14_function_that_converts_recursively_array_and_stdClass_each_other.php)

### オーバーライドしたメソッドだけに引数を追加する時は、デフォルト値を追加すれば問題ない。
2017-09-14 [source](./2017-09-14_if_add_argument_to_only_override_method_you_must_add_default_value.php)
引数を省略出来るということは、親メソッドのシグネチャで呼び出すことが可能ということ。

### 生成するクラス名を注入して、生成処理だけをメソッド化する。
2017-09-14 [source](./2017-09-14_inject_generated_class_ame_and_make_method_for_generating_it.php)

### interfaceの実装先で、戻り値のタイプヒントを変更したい。
2017-09-14 [source](./2017-09-14_modify_typehint_of_returned_value_in_interface_implementation.php)
同じシグネチャのloginメソッドでUserとAdminのどちらかを返す。

### 同じクラス変数名を子クラスで再定義しないと、親と他の子クラス全体で共有される。
2017-09-14 [source](./2017-09-14_share_class_property_with_parent_and_other_child_class_if_you_do_not_redefine_same_class_value_name_in_child.php)
親が抽象クラスで親とクラス変数を共有しない場合は、親に定義しない方が良いと思う。
親では定義をコメントアウトして、子クラスで定義するようにコメントしておくと良い。

### selfは自分自身に置き換わるので、継承先ではタイプヒントにparentで同値になる。
2017-09-14 [source](./2017-09-14_typehint_self_will_be_replaced_self_class_name_and_must_use_typehint_parent_in_child.php)

### amazonの商品データを自作モデルで簡単に取得できるように、apai-ioのラッパークラスを作る。
2017-09-17 [source](./2017-09-17_make_wrapper_for_apai-io_to_get_amazon_products_as_my_model.php)
取得結果はSimpleXMLElementで複雑な構造のため、モデルクラスに入れる。
title, image, descriptionのみを持つ。

### ファイル名を判断して出力する処理を、Factoryパターンで抽出する。
2017-09-18 [source](./2017-09-18_extract_proccessing_with_factory_pattern_to_judge_from_filename.php)
[PHPによるデザインパターン入門 \- Factory Method～生成処理と使用処理を分離する \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141215/1418620242)

### 1クラス1バリデーションに分けて処理を繋げるChain of Responsibility
2017-09-18 [source](./2017-09-18_separate_it_into_1_class_and_1_validation_and_join_with_chain_of_responsibility_pattern.php)
[PHPによるデザインパターン入門 \- Chain of Responsibility～処理のたらい回し \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141216/1418705161)

外側に分かりやすいAPI validate(メソッド名)を提供しているので、コンクリートクラスで実際に実装するメソッド名はexecValidationにしている。
publicなAPIの方を優先して分かりやすくする。

> Chain of Responsibilityパターンの特徴は、処理オブジェクトのチェーンです。つまり、Handler型のオブジェクトのチェーンです。
> チェーンの組み替えや、新しいConcreteHandlerクラスを追加したりできる

直接メインロジックにifの分岐を書かず、代わりにConcreteHandlerを追加する。これにより判定条件を使いまわすことができる。

### VCRでtwitterクライアントで呼び出したAPIの通信内容をキャッシュする。
2017-09-19 [source](./2017-09-19_cache_communication_content_of_api_called_by_twitter_client_with_vcr.php)

### Abstract FactoryでDaoをモックする。
2017-09-19 [source](./2017-09-19_mock_dao_with_abstract_factory_pattern.php)
[PHPによるデザインパターン入門 \- Abstract Factory～関連する部品をまとめて作る工場 \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141215/1418620420)

生成するものについての実装もする必要はなく、共通のAPIを使って開発ができる。
interfaceだけを意識して開発するをFactoryといった感じ。

### VCRを使い、HTTPリクエストとレスポンスをファイルキャッシュして、外部APIをテストする。
2017-09-19 [source](./2017-09-19_test_external_api_file_catching_http_request_and_response_with_vcr.php)
[php\-vcr/php\-vcr: Record your test suite's HTTP interactions and replay them during future test runs for fast, deterministic, accurate tests\.](https://github.com/php-vcr/php-vcr)

### 配列からの多重代入は、プロパティも指定できる。
2017-09-20 [source](./2017-09-20_multiple_assignment_from_array_can_be_used_into_also_property.php)

### 定数とクラス変数は文字列の中で展開できない。
2017-09-24 [source](./2017-09-24_can_not_expand_const_and_class_value_in_string.php)

### json_encodeにインスタンスを渡すとpublicプロパティが使用される。
2017-09-25 [source](./2017-09-25_json_encode_uses_public_property_when_give_an_instance.php)

### タイプヒントの子クラスを引数として渡すことは可能
2017-09-27 [source](./2017-09-27_can_pass_a_child_class_of_typehint_as_argument.php)

### タイプヒントにstdClassが使える
2017-09-27 [source](./2017-09-27_stdclass_can_be_used_as_typehint.php)

### 外側だけでなく、メソッド内で自身の存在しないプロパティにアクセスした時にも__getは呼び出される。
2017-10-01 [source](./2017-10-01_call_magic_method_get_when_access_property_does_not_exist_in_own_method.php)

### array_key_existsを$thisに使う前に、get_object_varsを使ってプロパティの有無を確認する。
2017-10-01 [source](./2017-10-01_confirm_if_property_exists_with_array_key_exists_and_get_object_vars.php)

### 同じプロパティ名とメソッド名を定義できるので、使い分けができる。
2017-10-01 [source](./2017-10-01_define_same_name_in_property_and_method.php)

### 親クラスのプロパティのみを取得したい時はget_class_varsを使う
2017-10-07 [source](./2017-10-07_get_only_parent_properties_with_get_class_vars.php)

### get_object_varsの戻り値で、値がオブジェクトのプロパティの中身を変えると、元のオブジェクトまで変わる。
2017-10-07 [source](./2017-10-07_modify_property_value_of_object_returned_by_get_object_vars_and_then_original_object_is_changed.php)
オブジェクトの場合は参照が渡っているため。

### エイリアスのプロパティはcloneすると値ではなく、参照をコピーするので元のオブジェクトに影響する。
2017-10-12 [source](./2017-10-12_alias_property_affects_original_when_clone.php)

### Closure::fromCallableを使っても、protected/privateメソッドにアクセスできない。
2017-10-16 [source](./2017-10-16_Closure_fromCallable_can_not_access_protected_and_private_methods.php)

### Closure::callで非publicメンバにアクセスする
2017-10-16 [source](./2017-10-16_access_not_public_members_with_Closure_call.php)
Closure::callでboolを返す判定メソッドを作った。
使う時にcallというタイプヒントも増えるので今回の使い方だと、関数定義の方がメリットが有る。
Closureだと`$this`にタイプヒントが使えない。

メリットは`$this`に束縛するので、非publicメンバにアクセス出来ること。
テスト時に役に立ちそう。

### Closure::fromCallableで関数名と文字列を区別する
2017-10-16 [source](./2017-10-16_distinguish_function_name_from_string_with_Closure_fromCallable.php)
下記の記事によるとlaravelのCollectionのメソッドに、グローバル関数をclosureとして渡せるとある。
しかし、is_floatだと引数が2つ渡るから警告が出る。
[Joseph Silber](https://josephsilber.com/posts/2016/07/13/closure-from-callable-in-php-7-1#table-of-contents)

### traitにinterfaceが使えないので他のtraitで代用する
2017-10-16 [source](./2017-10-16_use_trait_insteadof_interface.php)
抽象メソッド集のtraitを、traitでuseすれば良い。
PrifixはHasかDeclares。後者が良い気がする。

### サーバーサイドでcheckboxで選択した行のフォームデータのみを取得
2017-11-08 [source](./2017-11-08_get_selected_form_data_with_checkbox_at_server_side.php)
checkbox以外は常にデータが送られるため、全てのデータからcheckした行のみを抽出する。
jsを使いクライアントで、先に抽出してcheckした行のみをPOSTしても良い。

`users[1][name]`とname属性のkeyにはレコードのidを使う。checkboxには`<input type="checkbox" name="selectedIds[]" value="1">`とレコードのidを入れる。checkboxは選択したユーザーのkeyになる。

### フォームデータで、連想配列を使わずカラムごとにnameを分けて、サーバーサイドで連想配列にする。
2017-11-08 [source](./2017-11-08_modify_array_to_associative_of_form_data_dividing_name_each_columns_at_server_side.php)
`users[4][name]`ではなく、`user_names[4]`とする。

### privateメソッドをclosure変換して外部で使う。
2017-11-10 [source](./2017-11-10_change_private_method_to_closure_and_use_it_at_outside.php)

### Closure::bindを使って、privateなテストを楽する。
2017-11-10 [source](./2017-11-10_make_private_test_easy_with_closure_bind.php)

### privateプロパティから値を取得するリフレクションのヘルパー関数を作成
2017-11-10 [source](./2017-11-10_make_reflection_helper_function_to_get_value_from_private_property.php)

### 文字列の変数展開でメソッドを呼び出すことができる
2017-12-11 [source](./2017-12-11_can_use_method_in_string.php)

### array_key_existsはオブジェクトにも使える
2017-12-13 [source](./2017-12-13_can_use_array_key_exists_to_object.php)

### オブジェクトのUndefinedプロパティへアクセスした時は、Noticeになるがarray_key_existsでは発生しない。
2017-12-13 [source](./2017-12-13_not_occur_undefined_property_notice_in_array_key_exists.php)
strict_typesを有効にしてもNoticeがエラーになることはない。

### undefinedプロパティのアクセスに否定のビックリマークを使ってもNoticeは発生する
2017-12-13 [source](./2017-12-13_occur_notice_even_if_use_exclamation_mark_when_access_undefined_property.php)

### Warning:  mb_convert_encoding(): Unable to detect character encodingを発生させる
2017-12-13 [source](./2017-12-13_occur_waring_for_that_unable_to_detect_charcter_encoding.php)

### 配列のプロパティを初期化する時に、クラス定数が使える。
2017-12-14 [source](./2017-12-14_can_use_class_const_when_init_property_of_array.php)

### __toStingの中でエラーが発生してもスタックトレースで発生箇所の行数が分からない。
2017-12-14 [source](./2017-12-14_cannot_know_line_number_of_error_from_stack_trace_for_tostring.php)
> __toString() メソッド内から例外を投げることはできません。そうした場合、致命的なエラーが発生します。
http://php.net/manual/ja/language.oop5.magic.php

> Fatal error: Method class@anonymous::__toString() must not throw an exception, caught Error:
が発生するから追えない?

### str_replaceでブラケットを変数とした超簡単テンプレートシステムを作る
2017-12-14 [source](./2017-12-14_simple_template_system_with_str_replace.php)
{{NAME}}でテンプレートシステム用の変数となる。

### rewindはカーソルが0になるだけで、内容が残る。
2017-12-15 [source](./2017-12-15_rewind_move_cursor_to_postion_0_but_not_clear_content.php)

### 出力したDFP(広告)タグの分だけ、Javascriptを出力する。
2017-12-29 [source](./2017-12-29_add_javascript_of_only_rendered_dfp.php)

### 連想配列に入れたクロージャを呼び出す
2017-12-29 [source](./2017-12-29_call_closure_in_associative_array.php)

### 一番外側のHTMLタグをphp-simple-html-dom-parserで変換する
2017-12-29 [source](./2017-12-29_change_most_outer_html_tag_with_php_simple_html_dom_parser.php)

### 組み込み関数strip_tagsの挙動を確認する
2017-12-29 [source](./2017-12-29_confirm_behavior_of_strip_tags.php)
許可したHTMLタグだけ削除しないホワイトリスト方式

### LaravelのCarbonを使ってみる
2017-12-29 [source](./2017-12-29_try_to_use_carbon.php)
毎回インスタンス生成時にtimezoneを設定しないといけないのか？

### 複数トレイトをuseして衝突するとfatalエラーだが、トレイトでトレイトを使った場合はオーバーライドされる。
2018-01-09 [source](./2018-01-09_trait_in_trait_overrides_method_but_not_occur_fatal_error.php)

### ReflectionClassを使ったコンストラクタを呼び出さずにインスタンスを生成
2018-01-18 [source](./2018-01-18_new_instance_without_construct_by_reflectionclass.php)
ReflectionClassを使ってもprivateのコンストラクタにはアクセス出来ない。

### クラス定数でプロパティを初期化する
2018-01-23 [source](./2018-01-23_init_property_with_class_const_value.php)

### 文字展開の波括弧を二重にすると、変数名を動的に解決できる。
2018-01-25 [source](./2018-01-25_dynamic_resolve_variable_name_width_double_curly_braces.php)

### JavascriptのMobius1/SelectrのEventクラスをPHPで書き直す
2018-01-30 [source](./2018-01-30_rewrite_event_class_of_mobius1_selectr_in_javascript.php)
Github: https://github.com/Mobius1/Selectr
offの時に関数としてクロージャを渡せない。変数を渡す必要がある。

### デフォルトでcloneはプリミティブなプロパティをコピーしてくれる。
2018-02-05 [source](./2018-02-05_clone_copies_primitive_property_by_default.php)

### `__get`を上書きしても、Collectionはアクセス自体しないので意味がない。
2018-02-05 [source](./2018-02-05_overwriting_get_is_meaningless_because_collection_does_not_access_undefined_property.php)

### 引数の配列は、再代入してからunsetしないと副作用が出る。
2018-02-05 [source](./2018-02-05_unset_array_of_argument_without_reassigning_causes_a_side_effect.php)

### 引数が配列の場合はunsetしても副作用はないが、objectだと副作用がある。
2018-02-05 [source](./2018-02-05_unset_causes_a_side_effect_to_object_but_array.php)

### laravelのcollectionのwhenは真の時のみ、collectionを受取り加工する。
2018-02-06 [source](./2018-02-06_laravel_collection_gets_a_collection_and_processs_it_when_true.php)

### PhpRedisを拡張して使いやすくする
2018-02-06 [source](./2018-02-06_make_php_redis_easy_to_use_by_extending.php)

### PhpRedisにprefixを有効にすると、keyに自動で付与される。
2018-02-06 [source](./2018-02-06_php_redis_adds_a_prefix_to_key_if_enables_its_option.php)

### PhpRedisで値を更新する
2018-02-06 [source](./2018-02-06_update_values_with_php_redis.php)

### 引数が省略されたら、環境変数の値をカンマで分割する。
2018-02-07 [source](./2018-02-07_divide_env_value_by_comma_when_omitting_a_argument.php)

### PHP7でforeachでポインタが使われなくなったことを確認する
2018-02-07 [source](./2018-02-07_php_7_does_not_use_pointer_in_foreach.php)
`end()`の後に`reset()`を呼び出す必要はなくなった。
[PHPのforeachで参照渡しを使ったときの落とし穴 \- Qiita](https://qiita.com/ttskch/items/c6d8ea00c57640c52cd8)

### publicなコンストラクタをオーバーライドしてprivateにできない
2018-02-13 [source](./2018-02-13_can_not_change_public_construct_to_private_overwriting.php)

### Redisのコンストラクタを拡張して接続までする
2018-02-13 [source](./2018-02-13_extend_construct_of_redis_to_connect.php)

### 配列の一番深い階層を調べる
2018-02-19 [source](./2018-02-19_search_how_long_deep_of_array.php)
thanks: https://stackoverflow.com/questions/262891/is-there-a-way-to-find-out-how-deep-a-php-array-is

### 配列のネストした要素も含めて、全体のカラム数を調べる。
2018-02-20 [source](./2018-02-20_search_number_of_entire_columns_including_nested_array.php)

### for文の条件文に関数を使うと毎回実行される。
2018-02-21 [source](./2018-02-21_execute_function_each_loop_in_conditional_of_for_statement.php)

### キャプチャしたものもpreg_splitの結果に含める
2018-02-21 [source](./2018-02-21_include_captured_into_reesult_of_preg_split.php)

### Twitter Public APIのsince_idとmax_idの挙動を調べる
2018-02-21 [source](./2018-02-21_search_since_id_and_max_id_of_twitter_public_api.php)
since_idとmax_idのどちらを指定しても、最新からcount分を取得しようとする。
max_idは最新のラインを下げるのに使う。
since_idからcount分を取得するわけではない。

max_idは「以下」を表し、指定idのツイートも含む。
since_idは「より大きい」を表し、指定idのツイートを含まない。

### foreachで次の要素を取得するのにnextを使う
2018-02-21 [source](./2018-02-21_use_next_in_foreach.php)
nextがない場合はfalseを返す。
nextを1ループで複数回使うと困る。