<?php

namespace App\Modules\Qualification;

class QualificationFactory
{
    /**
     * @param string $code
     * @param string $title
     * @param string $description
     * @param string $subjectInformation
     * @param string $isSuperseded
     * @return Qualification
     */
    public static function factory($code, $title, $description, $subjectInformation, $isSuperseded='no')
    {
        return new Qualification($code, $title, $description, $subjectInformation, $isSuperseded);
    }
}
