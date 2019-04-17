<?php


namespace App\Helpers;

use KevinEm\OAuth2\Client\AdobeSign as Base;

class AdobeSignProvider extends Base
{

    protected $dataCenter = 'secure.eu1';
}