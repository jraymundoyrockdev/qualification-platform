<?php

namespace App\Services\Sync;

use App\Exceptions\PageNotFoundException;
use App\Exceptions\NotAValidQualificationException;
use App\Modules\Qualification\QualificationBuilder;
use App\Repositories\Contracts\QualificationRepository;
use App\Services\Sync\TGASOAP;

class SyncQualificationService
{
    const HTML_URL = 'http://training.gov.au/Training/Details/';
		const WSDL = 'https://ws.training.gov.au/Deewr.Tga.Webservices/TrainingComponentServiceV4.svc?wsdl';
    //const WSDL = 'https://ws.training.gov.au/Deewr.Tga.Webservices/OrganisationServiceV4.svc?wsdl';

    protected $qualification;
    protected $soapClient;
    protected $isCoreOrElective = ["" => 'elective', "0" => 'elective', "1" =>'core'];
    protected $qualificationBuilder;

    public function __construct(QualificationRepository $qualification, TGASOAP $soapClient, QualificationBuilder $qualificationBuilder)
    {
        $this->qualification = $qualification;
        $this->soapClient = $soapClient;
        $this->qualificationBuilder = $qualificationBuilder;
    }

    public function sync($qualificationCode)
    {
        $qualification = [];

        $htmlContent = $this->getHtmlContent($qualificationCode);

        $qualification['title'] = $this->getTitle($htmlContent);

        if ($qualification['title'] == 'Search criteria') {
            throw new PageNotFoundException();
        }

        $qualificationFromSoap = $this->soapClient->getDetailedResult(self::WSDL, $qualificationCode);

        if ($qualificationFromSoap->GetDetailsResult->ComponentType != 'Qualification') {
            throw new NotAValidQualificationException();
        }

          $qualification = QualificationBuilder::instance()->buildInformation(
              $qualificationCode,
              $this->getTitle($htmlContent),
              $this->getDescription($htmlContent),
              $this->getPackagingRules($htmlContent),
              strtolower($qualificationFromSoap->GetDetailsResult->CurrencyStatus)
          );

          print_r($qualification); die;
    /*    $qualification = QualificationFactory::factory(
            $qualificationCode,
            $this->getTitle($htmlContent),
            $this->getDescription($htmlContent),
            $this->getPackagingRules($htmlContent),
            strtolower($qualificationFromSoap->GetDetailsResult->CurrencyStatus)
        );
*/
        $this->qualification->create($qualification);

        return $qualification;
    }

    public function syncAll()
    {
        $qualificationDbIds = [];
        $qualificationFromDB = $this->qualification->findAll();

        foreach ($qualificationFromDB as $qualification) {

        }

        $soapData = $this->getInformationFromSOAP('MEA');

        $crawlerData = $this->getInformationFromCrawler();
    }

    private function getHtmlContent($qualificationCode)
    {
        return file_get_contents(self::HTML_URL . $qualificationCode);
    }

    private function getJobRoles($htmlContent)
    {
        $jobRolesPosition = strpos($htmlContent, '<STRONG class="&#xA;                ait24">Job roles</STRONG>');
        $pathwaysInformation = strpos($htmlContent, '<h2>Pathways Information</h2>');

        $result = substr ($htmlContent, $jobRolesPosition, ($pathwaysInformation - $jobRolesPosition));
        $result = str_replace('</li>', '', $result);
        $result = str_replace('</ul>', '', $result);

        $explodedResult = explode('<li>', $result);
        unset($explodedResult[0]);

        return $explodedResult;
    }

    private function getTitle($htmlContent)
    {
        $result = '';
        $h1Position = strpos ($htmlContent, '</h1>');
        $h2Position = strpos ($htmlContent,'</h2>');
        $result = substr ($htmlContent, $h1Position, ($h2Position - $h1Position));
        $result = strip_tags($result, '<a>');
        $h2Position = strpos ($result,' - ');
        $result = substr ($result, $h2Position + 3);

        return $this->trimmer($result);
    }

    private function getDescription($htmlContent)
    {
        $qualificationDescriptionPosition = strpos($htmlContent, '<h2>Qualification Description</h2>');

        if(! $qualificationDescriptionPosition) {
            $qualificationDescriptionPosition = strpos($htmlContent, '<h2>Description</h2>');
        }

        $secondPosition = strpos($htmlContent, '<EM class="&#xA;                ait7">Licensing/Regulatory Information </EM>');

        if (! $secondPosition){
            $secondPosition = strpos($htmlContent, '<STRONG class="&#xA;                ait24">Licensing/Regulatory Information</STRONG>');
        }

        if (! $secondPosition) {
            $secondPosition = strpos($htmlContent, '<P class="&#xA;                ait4">Licensing/Regulatory Information </P>');
        }

        if (! $secondPosition) {
            $secondPosition = strpos($htmlContent, '<STRONG class="&#xA;                ait24">Job roles</STRONG>');
        }

        if (! $secondPosition) {
            $secondPosition = strpos($htmlContent, '<h2>Entry Requirements</h2>');
        }

         $result = substr(
                      $htmlContent,
                      $qualificationDescriptionPosition,
                      ($secondPosition - $qualificationDescriptionPosition)
                  );

         $result = strip_tags($result, 'P class="&#xA;                ait4"');
         $result = str_replace('Qualification Description', '', $result);
         $result = str_replace('Description', '', $result);

         return $result = trim(preg_replace('/\s+/', ' ', $result));
    }

    private function getPackagingRules($htmlContent)
    {
        $result = '';

        $packagingRuleFirstPosition = strpos($htmlContent, '<h2>Packaging Rules</h2>');

        $coreUnitsPosition = strpos($htmlContent, '<STRONG class="&#xA;                ait24">Core units</STRONG>');

        if (! $coreUnitsPosition) {
            $coreUnitsPosition = strpos($htmlContent, '<STRONG class="&#xA;                ait24">Core units</STRONG>');
        }

        if (! $coreUnitsPosition) {
            $coreUnitsPosition = strpos($htmlContent, '<STRONG class="&#xA;                ait24">Core Units</STRONG>');
        }

        if(! $coreUnitsPosition) {
            $coreUnitsPosition = strpos($htmlContent, '<STRONG class="&#xA;                ait24">Elective Units</STRONG>');
        }

        if (! $coreUnitsPosition) {
            $coreUnitsPosition = strpos($htmlContent, '<TABLE class="ait-table" width="943">');
        }

        $result = substr(
                      $htmlContent,
                      $packagingRuleFirstPosition,
                      ($coreUnitsPosition - $packagingRuleFirstPosition)
                  );

        $result = str_replace('<P class="&#xA;                ait4">', '', $result);
        $result = str_replace('</P>', '<br>', $result);
        $result = str_replace('</STRONG>&nbsp;', '</strong>', $result);
        $result = str_replace("<ul class='ait13'>", '<ul>', $result);
        $result = str_replace('<STRONG class="&#xA;                ait24">', '<strong>', $result);
        $result = str_replace('<h2>Packaging Rules</h2>', '', $result);

        return $result;
      }

      private function getCurrencyIfSuperseded($currency)
      {
          return ($currency != 'Current') ? 'yes' : 'no';
      }

      private function getUnits($qualificationFromSoap)
      {
          if (is_array($qualificationFromSoap->GetDetailsResult->Releases->Release)) {

              if(! property_exists($units = $qualificationFromSoap->GetDetailsResult->Releases->Release[0]->UnitGrid, 'UnitGridEntry') ) {
                  return [];
              }

              $units = $qualificationFromSoap->GetDetailsResult->Releases->Release[0]->UnitGrid->UnitGridEntry;
              } else {
                  $units = $qualificationFromSoap->GetDetailsResult->Releases->Release->UnitGrid->UnitGridEntry;
              }

          if(! $units) {
              return [];
          }

          $hacker = '<p>';
          foreach ($units as $unit) {
              $result[$this->isCoreOrElective[$unit->IsEssential]][] = [
                  'code' => $unit->Code,
                  'title' => $unit->Title,
                  'subgroup' => ''
              ];

              if(!$unit->IsEssential) {
                  $hacker.=$unit->Code . ' ' . $unit->Title . '<br>';
              }

          }
          $hacker.='</p>';
          $result['concatinatedUnit'] = $hacker;

          return $result;
      }

      private function trimmer($string)
      {
          return trim($string);
      }
}
