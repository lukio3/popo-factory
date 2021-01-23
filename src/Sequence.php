<?php

namespace Morrislaptop\PopoFactory;

class Sequence
{
    protected int $index = 0;
    protected int $last;
    protected $sequence;

    public function __construct(...$sequence)
    {
        $this->sequence = $sequence;
        $this->last     = count($sequence) - 1;
    }

    public static function make(...$sequence)
    {
        return new self(...$sequence);
    }

    public function __invoke()
    {
        return $this->cycleIndexAfter($this->sequence[$this->index]);
    }

    /**
     * Allows us to cycle the index after retrieving the sequence value
     * and before returning it.
     */
    private function cycleIndexAfter($val)
    {
        $this->index++;

        if ($this->index > $this->last) {
            $this->index = 0;
        }

        return $val;
    }
}
