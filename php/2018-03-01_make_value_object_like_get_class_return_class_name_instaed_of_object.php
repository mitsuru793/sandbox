<?php
/*
get_classでobjectはクラス名を返すようなValueObjectを作る
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

final class TypeName
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * 型を調べる。objectはクラス名に変換される。
     * @param mixed $value
     */
    public static function detect($value): self
    {
        $type = gettype($value);
        if ($type === 'object') {
            $type = get_class($value);
        }
        return new self($type);
    }

    public function __toString()
    {
        return $this->value;
    }
}

$patterns = [
    ['hello', 'string'],
    [[1,2], 'array'],
    [new stdClass, 'stdClass'],
    [new DateTime, 'DateTime'],
];

foreach ($patterns as $pattern) {
    [$input, $expected] = $pattern;
    $type = TypeName::detect($input);
    assert((string)$type === $expected);
}
