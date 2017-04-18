<?php

use App\Services\Sync\TGASOAP;
use App\Exceptions\WSDLNotFoundException;
use Symfony\Component\Debug\Exception\FatalErrorException;

class TGASOAPTest extends BaseTestCase
{
    protected $soap;

    public function setUp()
    {
        parent::setUp();

        $this->soap = $this->app->make(TGASOAP::class);
    }


    public function it_returns_exception_on_invalid_wsdl()
    {
        $this->setExpectedException(WSDLNotFoundException::class);

        try {
          $result = $this->soap->setSOAPClient('INVALID SOAP');
        } catch (FatalErrorException $e){

        };
    }


}
