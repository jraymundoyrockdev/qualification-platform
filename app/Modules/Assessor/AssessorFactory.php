<?php

namespace App\Modules\Assessor;

class AssessorFactory
{
    /**
     * @param string $name
     * @param string $email
     * @param string $mobile
     * @param string $notes
     * @param string $type
     * @return Assessor
     */
    public static function factory($name, $email, $mobile, $notes, $type)
    {
        return new Assessor($name, $email, $mobile, $notes, $type);
    }
}
