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

### タイプヒントに使われている型の子クラスは許容できない。インターフェースを使う。
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
...

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