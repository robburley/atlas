<?php

namespace App\Console\Commands\Dxi;


use App\Helpers\Dxi\Traits\DxiApiHelpers;
use App\Models\Dxi\DxiAgent;
use App\Models\Dxi\DxiCall;
use App\Models\Dxi\DxiLogin;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class GetDxiCallsForTheLastFiveMinutes extends Command
{
    use DxiApiHelpers;

    public $start;
    public $end;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:get-dxi-calls {start?} {end?}';

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

        $this->start = Carbon::now()->subMinutes(10);

        $this->end = Carbon::now()->addMinutes(5);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('start') && $this->argument('end')) {
            $validator = Validator::make([
                'start' => $this->argument('start'),
                'end'   => $this->argument('end')
            ], [
                'start' => 'date_format:Y-m-d H:i:s',
                'end'   => 'date_format:Y-m-d H:i:s'
            ]);

            if (!$validator->passes()) {
                return $this->error('Input Error - get better with your dates...');
            }

            $this->start = Carbon::createFromFormat('Y-m-d H:i:s', $this->argument('start'));

            $this->end = Carbon::createFromFormat('Y-m-d H:i:s', $this->argument('end'));
        }

        $calls = $this->getCalls($this->start, $this->end);

        $calls->each(function ($call) {
            DxiCall::firstOrCreate([
                'callid' => $call->callid,
                'day'         => $this->validateDate($call->datetime)
                    ? Carbon::createFromFormat('Y-m-d H:i:s', $call->datetime)->startOfDay()
                    : null,
            ], [
                'qid'         => $call->qid,
                'dataset'     => $call->dataset,
                'urn'         => $call->urn,
                'agent'       => $call->agent,
                'ddi'         => $call->ddi,
                'cli'         => $call->cli,
                'ringtime'    => $call->ringtime,
                'duration'    => $call->duration,
                'result'      => $call->result,
                'outcome'     => $call->outcome,
                'type'        => $call->type,
                'carrier'     => $call->carrier,
                'flags'       => $call->flags,
                'terminate'   => $call->terminate,
                'customer'    => $call->customer,
                'datetime'    => $this->validateDate($call->datetime)
                    ? Carbon::createFromFormat('Y-m-d H:i:s', $call->datetime)
                    : null,
                'answer'      => $this->validateDate($call->answer)
                    ? Carbon::createFromFormat('Y-m-d H:i:s', $call->answer)
                    : null,
                'disconnect'  => $this->validateDate($call->disconnect)
                    ? Carbon::createFromFormat('Y-m-d H:i:s', $call->disconnect)
                    : null,
                'last_update' => $this->validateDate($call->last_update)
                    ? Carbon::createFromFormat('Y-m-d H:i:s', $call->last_update)
                    : null,
            ]);
        });
    }

    public function validateDate($field)
    {
        return $field && $field != '0000-00-00 00:00:00';
    }
}
