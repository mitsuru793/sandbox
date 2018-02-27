<?php
/*
invokeでcounterを作る
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class Counter
{
    private $count;
    private $step;

    public function __construct(int $init = 1, $step = 1)
    {
        $this->count = $init - $step;
        $this->step = $step;
    }

    public function __invoke(): int
    {
        $this->count += $this->step;
        return $this->count;
    }
}

$counter = new Counter(1, 2);
assert($counter() === 1);
assert($counter() === 3);
assert($counter() === 5);
