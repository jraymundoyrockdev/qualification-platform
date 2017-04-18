<?php

namespace App\Services\Sync;

use App\Resolvers\ProvidesSOAPCredentials;
use SoapClient;
use SoapHeader;
use SoapVar;

class TGASOAP implements SOAPInterface
{
    use ProvidesSOAPCredentials;

    //const WSDL = 'https://ws.training.gov.au/Deewr.Tga.Webservices/OrganisationServiceV4.svc?wsdl';

    const OASIS = 'http://docs.oasis-open.org/wss/2004/01';
    const PASSWORD_TYPE = 'PasswordText';

    protected $soapClient ;
    protected $isCoreOrElective = ["" => 'elective', "0" => 'elective', "1" =>'core'];

    public function __construct()
    {

    }

    public function getDetailedResult($wsdl, $code)
    {
        $this->setSOAPClient($wsdl, ['trace' => 1, 'exception' => 0]);
        $this->setSOAPHEAder($this->getSOAPUsername(), $this->getSOAPPassword());

        $comdata = [
            'request' => [
                'Code' => $code,
                'InformationRequest' => [
                    'ShowReleases' => true,
                    'ShowUnitGrid' => true
                  ]
            ]
        ];

        return $this->soapClient->GetDetails($comdata);
    }

    private function setSOAPClient($wsdl, $paramters=[])
    {
        $this->soapClient = new SoapClient($wsdl, $paramters);
    }

    private function setSOAPHeader($username, $password)
    {
        $nonce = sha1(mt_rand());
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');

        $xml = '
            <wsse:Security SOAP-ENV:mustUnderstand="1" xmlns:wsse="' . self::OASIS . '/oasis-200401-wss-wssecurity-secext-1.0.xsd">
              <wsse:UsernameToken>
              <wsse:Username>' . $username . '</wsse:Username>
              <wsse:Password Type="' . self::OASIS . '/oasis-200401-wss-username-token-profile-1.0#' . self::PASSWORD_TYPE . '">' . $password . '</wsse:Password>
              <wsse:Nonce EncodingType="' . self::OASIS . '/oasis-200401-wss-soap-message-security-1.0#Base64Binary">' . $nonce . '</wsse:Nonce>';

                if (self::PASSWORD_TYPE === 'PasswordDigest') {
                    $xml .= "\n\t" . '<wsu:Created xmlns:wsu="' . self::OASIS . '/oasis-200401-wss-wssecurity-utility-1.0.xsd">' . $timestamp . '</wsu:Created>';
                }

                $xml .= '
              </wsse:UsernameToken>
            </wsse:Security>';

        $header =

        $this->soapClient->__setSoapHeaders($this->generateSoapHeader($xml));
    }

    private function generateSoapHeader($xml)
    {
        return new SoapHeader(
            self::OASIS . '/oasis-200401-wss-wssecurity-secext-1.0.xsd',
            'Security',
            new SoapVar($xml, XSD_ANYXML),
            true
        );
    }
}
