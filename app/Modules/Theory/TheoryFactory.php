<?php

namespace App\Modules\Theory;

class TheoryFactory
{
    /**
     * @param string $title
     *
     * @return Theory
     */
    public static function create($title)
    {
        return new Theory($title);
    }
}
