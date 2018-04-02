<?php
/*
laravelのpipelineをシンプルにする

thanks: https://github.com/illuminate/pipeline
`__invoke`を実装すれば良いだけにする。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function main()
{
    $processed = (new Pipeline)->send(' hello ')
    ->through([
        function ($str, $next) {
            return $next(trim($str));
        },
        function ($str, $next) {
            return $next("[{$str}]");
        },
    ])->then(function ($str) {
        return $str;
    });
    dump($processed);
}

final class Pipeline
{
    /**
     * The object being passed through the pipeline.
     *
     * @var mixed
     */
    protected $passable;

    /**
     * The array of class pipes.
     *
     * @var array
     */
    protected $pipes = [];

    /**
     * Set the object being sent through the pipeline.
     *
     * @param  mixed  $passable
     * @return $this
     */
    public function send($passable)
    {
        $this->passable = $passable;

        return $this;
    }

    /**
     * Set the array of pipes.
     *
     * @param  array|callable  $pipes
     * @return $this
     */
    public function through($pipes)
    {
        $this->pipes = is_array($pipes) ? $pipes : [$pipes];

        return $this;
    }

    /**
     * Run the pipeline with a final destination callback.
     *
     * @param  \Closure  $destination
     * @return mixed
     */
    public function then(Closure $destination)
    {
        $next = function ($passable) use ($destination) {
            return $destination($passable);
        };

        $pipeline = array_reduce(array_reverse($this->pipes), $this->carry(), $next);

        return $pipeline($this->passable);
    }

    /**
     * Get a Closure that represents a slice of the application onion.
     *
     * @return \Closure
     */
    protected function carry(): Closure
    {
        return function (Closure $stack, callable $pipe) {
            return function ($passable) use ($stack, $pipe) {
                if (is_callable($pipe)) {
                    return $pipe($passable, $stack);
                }

                $parameters = [$passable, $stack];
                return $pipe(...$parameters);
            };
        };
    }
}

main();
