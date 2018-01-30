<?php
/*
JavascriptのMobius1/SelectrのEventクラスをPHPで書き直す

Github: https://github.com/Mobius1/Selectr
offの時に関数としてクロージャを渡せない。変数を渡す必要がある。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

final class Event
{
    /** @var array */
    private $events = [];

    public function on(string $eventName, callable $func): self
    {
        if (!array_key_exists($eventName, $this->events)) {
            $this->events[$eventName] = [];
        }
        $this->events[$eventName][] = $func;
        return $this;
    }

    public function off(string $eventName, callable $removeFunc): self
    {
        if (!array_key_exists($eventName, $this->events)) {
            return $this;
        }
        $newFuncs = [];
        foreach ($this->events[$eventName] as $func) {
            if ($func === $removeFunc) {
                continue;
            }
            $newFuncs[] = $func;
        }
        $this->events[$eventName] = $newFuncs;
        return $this;
    }

    public function emit(string $eventName, array $funcArgs): self
    {
        if (!array_key_exists($eventName, $this->events)) {
            return $this;
        }
        foreach ($this->events[$eventName] as $func) {
            $func(...$funcArgs);
        }
        return $this;
    }
}

$event = new Event;

$clickEvent1 = function (...$args) {
    puts('click event 1');
    dump($args);
};
$clickEvent2 = function (...$args) {
    puts('click event 2');
    dump($args);
};

$event
    ->on('click', $clickEvent1)
    ->on('click', $clickEvent2);

$focusEvent = function (...$args) {
    puts('click focus');
    dump($args);
};
$event->on('focus', $focusEvent);

$event->emit('click', ['arg1', 'arg2']);
$event->emit('focus', ['arg1', 'arg2']);

$event->off('click', $clickEvent2);
$event->emit('click', ['arg1']);
