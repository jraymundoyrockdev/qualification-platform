<?php

namespace App\Modules\Scientist;

class ScientistFactory
{
    /**
     * @param string $firstName
     * @param string $lastName
     *
     * @return Scientist
     */
    public static function create($firstName, $lastName)
    {
        return new Scientist($firstName, $lastName);
    }
}
