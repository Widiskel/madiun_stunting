<?php

namespace App;

class LCG {
    private $seed;
    private $a;
    private $c;
    private $m;
 
    public function __construct($seed, $a = 5, $c = 7, $m = 9) {
        $this->seed = $seed;
        $this->a = $a;
        $this->c = $c;
        $this->m = $m;
    }
 
    public function getNext() {
        $this->seed = ($this->a * $this->seed + $this->c) % $this->m;
        return $this->seed;
    }
}