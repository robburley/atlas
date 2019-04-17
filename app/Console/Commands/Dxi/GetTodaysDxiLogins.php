<?php

namespace App\Console\Commands\Dxi;


use App\Helpers\Dxi\Traits\DxiApiHelpers;
use App\Models\Dxi\DxiAgent;
use App\Models\Dxi\DxiLogin;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetTodaysDxiLogins extends Command
{
    use DxiApiHelpers;

    public $start;
    public $end;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:get-todays-dxi-logins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->start = Carbon::now()->startOfDay();

        $this->end = Carbon::now();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $agents = $this->getLogins($this->start, $this->end);

        $agents->only('list')->flatten(1)->each(function ($agent) {
            preg_match('#\((.*?)\)#', $agent->anm, $branch);

            DxiAgent::firstOrCreate([
                'agent_id' => $agent->aid,
            ], [
                'name'     => $agent->anm,
                'branch'   => array_key_exists(1, $branch) ? $branch[1] : 'Nantwich',
            ]);

            DxiLogin::updateOrCreate([
                'agent_id' => $agent->aid,
                'day'      => $this->start,
            ], [
                'first_login' => $agent->tm_login ? Carbon::createFromFormat('U', $agent->tm_login) : null,
                'last_logout' => $agent->tm_logout ? Carbon::createFromFormat('U', $agent->tm_logout) : null,
                'first_call'  => $agent->tm_first ? Carbon::createFromFormat('U', $agent->tm_first) : null,
                'last_call'   => $agent->tm_last ? Carbon::createFromFormat('U', $agent->tm_last) : null,
            ]);
        });
    }
}
