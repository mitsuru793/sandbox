<?php
/*
1クラス1バリデーションに分けて処理を繋げるChain of Responsibility

[PHPによるデザインパターン入門 \- Chain of Responsibility～処理のたらい回し \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141216/1418705161)

外側に分かりやすいAPI validate(メソッド名)を提供しているので、コンクリートクラスで実際に実装するメソッド名はexecValidationにしている。
publicなAPIの方を優先して分かりやすくする。

> Chain of Responsibilityパターンの特徴は、処理オブジェクトのチェーンです。つまり、Handler型のオブジェクトのチェーンです。
> チェーンの組み替えや、新しいConcreteHandlerクラスを追加したりできる

直接メインロジックにifの分岐を書かず、代わりにConcreteHandlerを追加する。これにより判定条件を使いまわすことができる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function run()
{
    // このようにメソッドチェーンでは書けない
    $handler = (new MaxLengthValidationHandler(3))
        ->setHandler(new AlphabetValidationHandler) // ここの戻り値がAlphabet~ではなくMaxLengthのため
        ->setHandler(new NotNullValidationHandler);

    // 最後のHandlerから生成していく
    $alphabetHandler = (new AlphabetValidationHandler)
        ->setHandler(new NotNullValidationHandler);
    $handler = (new MaxLengthValidationHandler(3))
        ->setHandler($alphabetHandler);

    $pattern = [
        '' => 'Entered nothing.',
        'abc' => true,
        'a2' => 'Enter half-width alphabet.',
    ];
    foreach ($pattern as $input => $expected) {
        $actual = $handler->validate($input);
        assert($expected === $actual);
    }
}

abstract class ValidationHandler
{
    private $nextHandler;

    public function __construct()
    {
        $this->nextHandler = null;
    }

    public function setHandler(ValidationHandler $handler)
    {
        $this->nextHandler = $handler;
        return $this;
    }

    public function getNextHandler()
    {
        return $this->nextHandler;
    }

    /**
     * チェーンの実行
     */
    public function validate($input)
    {
        $result = $this->execValidation($input);
        if (!$result) {
            return $this->getErrorMessage();
        } elseif (!is_null($this->getNextHandler())) {
            return $this->getNextHandler()->validate($input);
        } else {
            return true;
        }
    }

    /**
     * 担当する処理を実行
     */
    protected abstract function execValidation(string $input) : bool;

    /**
     * 処理失敗時のメッセージを取得する
     */
    protected abstract function getErrorMessage() : string;
}

class AlphabetValidationHandler extends ValidationHandler
{
    protected function execValidation(string $input) : bool
    {
        return (string)preg_match('/^[a-z]*$/i', $input);
    }

    protected function getErrorMessage() : string
    {
        return 'Enter half-width alphabet.';
    }
}

class NumberValidationHandler extends ValidationHandler
{
    protected function execValidation(string $input) : bool
    {
        return (preg_match('/^[0-9]*$/', $input) > 0);
    }

    protected function getErrorMessage() : string
    {
        return 'Enter half-width digit.';
    }
}

class NotNullValidationHandler extends ValidationHandler
{
    protected function execValidation(string $input) : bool
    {
        return !empty($input);
    }

    protected function getErrorMessage() : string
    {
        return 'Entered nothing.';
    }
}

class MaxLengthValidationHandler extends ValidationHandler
{
    private $maxLength;

    public function __construct(int $maxLength)
    {
        parent::__construct();
        if (0 > $maxLength && 99 < $maxLength) {
            throw new RuntimeException('max length is invalid (1-99) !');
        }
        $this->maxLength = $maxLength;
    }

    protected function execValidation(string $input) : bool
    {
        return (strlen($input) <= $this->maxLength);
    }

    protected function getErrorMessage() : string
    {
        return "Enter within {$this->maxLength} bytes.";
    }
}

run();
