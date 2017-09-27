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