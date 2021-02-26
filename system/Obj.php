<?php

namespace CodeIgniter;
use  \Tightenco\Collect\Support\Collection;

class Obj extends Collection
{
    function __get($key)
    {
        strtolower($key)
    }
}
