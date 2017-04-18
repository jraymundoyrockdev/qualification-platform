<?php

use App\Resolvers\ProvidesSOAPCredentials;

class ProvidesSOAPCredentialsTest extends BaseTestCase
{
    use ProvidesSOAPCredentials;

    /** @test*/
    public function it_provides_soap_username()
    {
        $this->assertNotEmpty($this->getSOAPUsername());
    }
    
    /** @test*/
    public function it_provides_soap_password()
    {
        $this->assertNotEmpty($this->getSOAPUsername());
    }
}
