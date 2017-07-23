<?php
/*
SymfonyのVaridationはクラスの他に、スカラ値も検証できる。

クラスにルールを追加するには、クラスメソッド、アノテーション、YAML、XMLがある。
*/

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


const VALIDATE_MESSAGE = 'This value is too long. It should have 5 characters or less.';

/*********************************************/
/* ClassMetadataを使わずにスカラ値を検証する */
/*********************************************/

$validator = Validation::createValidator();

// 名前は5文字以内に収めて、絶対に入力してもらう。
$violations = $validator->validate('Yamada', [
    new Length(['max' => 5]),
    new NotBlank,
]);

/** @var Symfony\Component\Validator\ConstraintViolationList $violations */
assert(1 === count($violations));
$violation = $violations->getIterator()[0];
assert(VALIDATE_MESSAGE === $violation->getMessage());

/********************************************/
/* 検証対象のクラスにルールを追加する */
/********************************************/

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Author
{
    // privateも自動でチェックしてくる。
    private $firstName;

    public function __construct($name)
    {
        $this->firstName = $name;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('firstName', new Assert\NotBlank);
        $metadata->addPropertyConstraint(
            'firstName',
            new Assert\Length(['max' => 5])
        );
    }
}

$validator = Validation::createValidatorBuilder()
    // 対象クラスのクラスメソッドを定義する
    ->addMethodMapping('loadValidatorMetadata')
    ->getValidator();
$violations = $validator->validate(new Author('Yamada'));

assert(1 === count($violations));
$violation = $violations->getIterator()[0];
assert(VALIDATE_MESSAGE === $violation->getMessage());
