<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

abstract class Opportunity extends Model
{
    abstract public function processAdobeSign();
}

