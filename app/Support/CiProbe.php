<?php

namespace App\Support;

// TEMPORARY: deliberate errors to prove that G2 fails. Removed in the next commit.
class CiProbe
{
    public function run( ) : string
    {
        $x=1;
        return $this->methodThatDoesNotExist();
    }
}
