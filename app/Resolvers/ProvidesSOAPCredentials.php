<?php

namespace App\Resolvers;

trait ProvidesSOAPCredentials
{ 
    public function getSOAPUsername()
    {
        return env('SOAP_USERNAME', true);
    }

    public function getSOAPPassword()
    {
        return env('SOAP_PASSWORD', true);
    }
}
