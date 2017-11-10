<?php
/*
privateメソッドをclosure変換して外部で使う。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function methodToFunc($object, string $methodName)
{
    $reflection = new ReflectionClass($object);
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);

    return function (...$args) use ($method, $object) {
        return $method->invoke($object, ...$args);
    };
}

class P
{
    private function hi($to, $msg)
    {
        return "Hi, {$to}. {$msg}.";
    }
}

$p = new P;
$method = methodToFunc($p, 'hi');
assert('Hi, mike. Bye.' === $method('mike', 'Bye'));
