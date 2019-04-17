<?php

namespace App\Helpers\Dxi\Traits;


use Carbon\Carbon;

trait DxiApiHelpers
{
    public $baseUri = 'https://api-106.dxi.eu/';

    public function getToken()
    {
        return $this->get($this->baseUri . 'token.php?action=get&username=532630&password=NEutMGUOAS3pxsBeqW')->get('token');
    }

    public function getLogins(Carbon $start, Carbon $end)
    {
        return $this->get($this->baseUri . 'reporting.php?token=' . $this->getToken() . '&format=json&method=agents&fields=aid,anm,tm_login,tm_logout,tm_first,tm_last&isset=tm_login&range=' . $start->format('U') . ':' . $end->format('U'));
    }

    public function getCalls(Carbon $start, Carbon $end)
    {
        return collect($this->get($this->baseUri . 'database.php?method=cdr_log&format=json&token=' . $this->getToken() . '&action=read&tstart=' . urlencode($start->format('Y-m-d H:i:s')) . '&tstop=' . urlencode($end->format('Y-m-d H:i:s')) . '&groupby=qid')->get('list'));
    }

    public function get($url)
    {
        return collect(json_decode(file_get_contents($url)));
    }
}