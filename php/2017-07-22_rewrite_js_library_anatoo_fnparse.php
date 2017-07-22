<?php
/*
anatoo/fnparse.jsをPHPで書き直す

[anatoo/fnparse\.js: An extremely simple parser combinator for JavaScript\.](https://github.com/anatoo/fnparse.js)
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Stringy\create as s;
use function Lib\puts;

/******************/
/* トークナイザー */
/******************/

function token(string $str) : Closure
{
    $len = count(s($str));
    return function(string $target, int $position) use ($str, $len) {
        if (s($target)->substr($position, $len) == $str) {
            return [true, $str, $position + $len];
        } else {
            return [false, null, $position];
        }
    };
}

function regex(string $regexp) : Closure
{
    if (s($regexp)[1] != '^') {
        $regexp = s($regexp)[0] . '^' . s($regexp)->substr(1);
    }
    return function(string $target, int $position) use ($regexp) {
        if (preg_match($regexp, (string)s($target)->substr($position), $matches)) {
            $position += count(s($matches[0]));
            return [true, $matches[0], $position];
        } else {
            return [false, null, $position];
        }
    };
}

function char(string $str) : Closure
{
    $dict = [];
    foreach (s($str) as $char) {
        // $charを代入してしまうと空文字列にマッチしても失敗する。
        $dict[$char] = true;
    }
    return function(string $target, int $position) use ($dict) {
        $char = (string)s($target)->substr($position, 1);
        if (isset($dict[$char])) {
            return [true, $char, $position + 1];
        } else {
            return [false, null, $position];
        }
    };
}

/**********************/
/* パーサーの連結関数 */
/**********************/

function many(callable $parser) : Closure
{
    return function(string $target, int $position) use ($parser) {
        $result = [];
        while(true) {
            $parsed = $parser($target, $position);
            if ($parsed[0]) {
                $result[] = $parsed[1];
                $position = $parsed[2];
            } else {
                break;
            }
        }
        return [true, $result, $position];
    };
}

function choice(...$parsers) : Closure
{
    return function(string $target, int $position) use ($parsers) {
        foreach ($parsers as $parser) {
            $parsed = $parser($target, $position);
            if ($parsed[0]) {
                return $parsed;
            }
        }
        return [false, null, $position];
    };
}

function seq(...$parsers) : Closure
{
    return function($target, $position) use ($parsers) {
        $result = [];
        $currentPosition = $position;
        foreach($parsers as $parser) {
            $parsed = $parser($target, $currentPosition);
            if ($parsed[0]) {
                $result[] = $parsed[1];
                $currentPosition = $parsed[2];
            } else {
                // // 一つでも失敗を返せば、このパーサ自体が失敗を返す。
                return [false, null, $position];
            }
        }
        return [true, $result, $currentPosition];
    };
}

function option(callable $parser) : Closure
{
    return function(string $target, int $position) use ($parser) {
        $result = $parser($target, $position);
        if ($result[0]) {
            return $result;
        } else {
            return [true, null, $position];
        }
    };
}


/****************/
/* callback関数 */
/****************/

function lazy(callable $callback) : callable
{
    $parser = null;
    return function(string $target, int $position) use ($callback, $parser) {
        if (is_null($parser)) {
            $parser = $callback();
        }
        return $parser($target, $position);
    };
}

function map(callable $parser, callable $callback) : Closure
{
    return function(string $target, int $position) use ($parser, $callback) {
        $result = $parser($target, $position);
        if ($result[0]) {
            return [$result[0], $callback($result[1]), $result[2]];
        } else {
            return $result;
        }
    };
}

function filter(callable $parser, callable $callback) : Closure
{
    return function(string $target, int $position) use ($parser, $callback) {
        $result = $parser($target, $position);
        if ($result[0]) {
            return [$callback($result[1]), $result[1], $result[2]];
        } else {
            return $result;
        }
    };
}

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @dataProvider tokenData
     */
    public function testToken($correct, $target, $position, $expected)
    {
        $parse = token($correct);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function tokenData()
    {
        return [
            # 全体にマッチ
            ['foobar', 'foobar', 0, [true, 'foobar', 6]],
            # 成功した箇所までしかpositionは進まない
            ['foobar', 'foobarbaz', 0, [true, 'foobar', 6]],
            # 与えたpositionから完全一致しないといけない
            ['foobar', 'bazfoobar', 0, [false, null, 0]],
            # 読み取り開始位置を変更することができる
            ['foobar', 'bazfoobar', 3, [true, 'foobar', 9]],
            # 空文字は空文字とだけマッチする
            ['', '', 0, [true, '', 0]], # positionは進まない
            ['foobar', '', 0, [false, null, 0]],
            # targetより後ろのpositionを与えた時
            ['a', 'a', 100, [false, null, 100]],
        ];
    }

    /**
     * @dataProvider regexData
     */
    public function testRegex($correct, $target, $position, $expected)
    {
        $parse = regex($correct);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function regexData()
    {
        return [
            # 全体にマッチ
            ['/foo/', 'foo', 0, [true, 'foo', 3]],
            # 正規表現が使える
            ['/[1-9][0-9]*/', '2014', 0, [true, '2014', 4]],
            ['/[1-9][0-9]*/', '01', 0, [false, null, 0]],
            # 空文字は空文字とだけマッチする
            ['//', '', 0, [true, '', 0]], # positionは進まない
            ['/foo/', '', 0, [false, null, 0]],
            # 自動で^がつくので失敗する
            ['/foo/', 'e', 0, [false, null, 0]],
            # targetより後ろのpositionを与えた時
            ['/foo/', 'e', 100, [false, null, 100]],
        ];
    }

    /**
     * @dataProvider charData
     */
    public function testChar($correct, $target, $position, $expected)
    {
        $parse = char($correct);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function charData()
    {
        return [
            # どれかを含めば成功
            ['abc', 'a', 0, [true, 'a', 1]],
            ['abc', 'b', 0, [true, 'b', 1]],
            ['abc', 'c', 0, [true, 'c', 1]],
            # どれも含まない場合は失敗
            ['abc', 'd', 0, [false, null, 0]],
            # 空文字はマッチしない
            ['', '', 0, [false, null, 0]],
            ['abc', '', 0, [false, null, 0]],
            # targetより後ろのpositionを与えた時
            ['abc', 'd', 100, [false, null, 100]],
        ];
    }

    /**
     * @dataProvider manyData
     */
    public function testMany($parser, $target, $position, $expected)
    {
        $parse = many($parser);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function manyData()
    {
        return [
            # マッチしたものが配列で返る。
            [token('foo'), 'foofoo', 0, [true, ['foo', 'foo'], 6]],
            # マッチしない時はnullの代わりに空配列を含む
            [token('foo'), 'bar', 0, [true, [], 0]],
        ];
    }

    /**
     * @dataProvider choiceData
     */
    public function testChoice($parsers, $target, $position, $expected)
    {
        $parse = choice(...$parsers);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function choiceData()
    {
        return [
            # 1つのパーサーにマッチしたら成功
            [[token('foo'), token('bar')], 'bar', 0, [true, 'bar', 3]],
            # 1つにマッチした時点比較を終了
            [[token('foo'), token('bar')], 'foo', 0, [true, 'foo', 3]],
            # どのパーサーにも一致しない場合は失敗
            [[token('foo'), token('bar')], 'baz', 0, [false, null, 0]],
        ];
    }

    /**
     * @dataProvider seqData
     */
    public function testSeq($parsers, $target, $position, $expected)
    {
        $parse = seq(...$parsers);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function seqData()
    {
        return [
            # 順番どおりに先頭からマッチする
            [[token('foo'), token('bar')], 'foobar', 0, [true, ['foo', 'bar'], 6]],
            [[token('foo'), token('bar')], 'barfoo', 0, [false, null, 0]],
        ];
    }

    /**
     * @dataProvider optionData
     */
    public function testOption($parser, $target, $position, $expected)
    {
        $parse = option($parser);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function optionData()
    {
        return [
            # falseを返すことがなく、常に成功
            [token('foo'), 'foo', 0, [true, 'foo', 3]],
            [token('foo'), 'bar', 0, [true, null, 0]],
        ];
    }

    /**
     * @dataProvider lazyData
     */
    public function testLazy($callback, $target, $position, $expected)
    {
        $parse = lazy($callback);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function lazyData()
    {
        return [
            # callbackで返したパーサーを使用(遅延評価)
            [function () { return token('foo'); }, 'foo', 0, [true, 'foo', 3]],
            [function () { return token('foo'); }, 'bar', 0, [false, null, 0]],
        ];
    }

    /**
     * @dataProvider mapData
     */
    public function testMap($parserAndCallback, $target, $position, $expected)
    {
        $parse = map(...$parserAndCallback);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function mapData()
    {
        $parser = [token('foo'), function ($result) { return $result . 'after'; }];
        return [
            # マッチした文字列をcallbackで処理できる
            [
                [token('foo'), function ($result) { return $result . 'after'; }],
                'foo', 0, [true, 'fooafter', 3]
            ],
            # マッチしない場合は
            [
                [token('foo'), function ($result) { throw new RuntimeException; }],
                'bar', 0, [false, null, 0]
            ],
        ];
    }

    /**
     * @dataProvider filterData
     */
    public function testFilter($parserAndCallback, $target, $position, $expected)
    {
        $parse = filter(...$parserAndCallback);
        $this->assertSame($expected, $parse($target, $position));
    }

    public function filterData()
    {
        $parser = token('foo');
        return [
            # マッチした場合は、callbackも戻りにより成否が決まる。
            [[$parser, function($result) { return true; }], 'foo', 0, [true, 'foo', 3]],
            [[$parser, function($result) { return false; }], 'foo', 0, [false, 'foo', 3]],
            # マッチしない場合は、callbackに関係なく失敗する。
            [[$parser, function($result) { return true; }], 'bar', 0, [false, null, 0]],
            [[$parser, function($result) { return false; }], 'bar', 0, [false, null, 0]],
        ];
    }
}
