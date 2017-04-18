<?php

namespace App\Services\Sync;

interface SOAPInterface {
    public function getDetailedResult($wsdl, $code);
}
