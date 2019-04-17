<?php


namespace App\Helpers;

use KevinEm\AdobeSign\AdobeSign as baseAdobeSign;

class AdobeSign extends baseAdobeSign
{
    protected $baseUri = 'https://api.eu1.echosign.com/api/rest';

    public function authorize()
    {
        return $this->getProvider()->authorize();
    }
}