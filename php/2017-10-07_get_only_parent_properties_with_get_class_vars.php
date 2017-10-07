<?php
/*
親クラスのプロパティのみを取得したい時はget_class_varsを使う
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class P
{
    public $parentPub;
    protected $parentPro;
    private $parentPri;

    public function classConst()
    {
        return __CLASS__;
    }

    public function classVars()
    {
        return get_class_vars(__CLASS__);
    }

    public function selfClassVars()
    {
        return get_class_vars(self::class);
    }

    public function thisVars()
    {
        return get_object_vars($this);
    }
}

class C extends P
{
    public $childPub;
    protected $childPro;
    private $childPri;
}

$parentAllProperties = [
  "parentPub" => null,
  "parentPro" => null,
  "parentPri" => null,
];

/*******/
/*  P  */
/******/
assert(['parentPub' => null] === get_class_vars(P::class));

$p = new P;
assert('P' === $p->classConst());
assert($parentAllProperties === $p->classVars());
assert($parentAllProperties === $p->selfClassVars());
assert($parentAllProperties === $p->thisVars());


/*******/
/*  C  */
/******/
$expected = [
  "childPub" => null,
  "parentPub" => null,
];
assert($expected === get_class_vars(C::class));

$c = new C;
assert('P' === $c->classConst());
assert($parentAllProperties === $c->classVars());
assert($parentAllProperties === $p->selfClassVars());
$expected = [
  "childPub" => null,
  "childPro" => null,
  "parentPub" => null,
  "parentPro" => null,
  "parentPri" => null,
];
assert($expected === $c->thisVars());
