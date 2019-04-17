<?php

namespace App\Console\Commands;


use App\Helpers\FonoApi;
use App\Models\Utilities\MobilePhoneModel;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UpdatePhoneList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atlas:update-phone-list';

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $token = '3d18d01c1ce02a22f6ae03317b45d57e33794cf48ebce494';

        $fonoapi = fonoApi::init($token);

        $brands = [
            'ACER',
            'ALCATEL',
            'ALLVIEW',
            'AMAZON',
            'AMOI',
            'APPLE',
            'ARCHOS',
            'ASUS',
            'AT&T',
            'BENEFON',
            'BENQ',
            'BENQ-SIEMENS',
            'BIRD',
            'BLACKBERRY',
            'BLU',
            'BOSCH',
            'BQ',
            'CASIO',
            'CAT',
            'CELKON',
            'CHEA',
            'COOLPAD',
            'DELL',
            'EMPORIA',
            'ENERGIZER',
            'ERICSSON',
            'ETEN',
            'FUJITSU SIEMENS',
            'GARMIN-ASUS',
            'GIGABYTE',
            'GIONEE',
            'GOOGLE',
            'HAIER',
            'HP',
            'HTC',
            'HUAWEI',
            'I-MATE',
            'I-MOBILE',
            'ICEMOBILE',
            'INNOSTREAM',
            'INQ',
            'INTEX',
            'JOLLA',
            'KARBONN',
            'KYOCERA',
            'LAVA',
            'LEECO',
            'LENOVO',
            'LG',
            'MAXON',
            'MAXWEST',
            'MEIZU',
            'MICROMAX',
            'MICROSOFT',
            'MITAC',
            'MITSUBISHI',
            'MODU',
            'MOTOROLA',
            'MWG',
            'NEC',
            'NEONODE',
            'NIU',
            'NOKIA',
            'NVIDIA',
            'O2',
            'ONEPLUS',
            'OPPO',
            'ORANGE',
            'PALM',
            'PANASONIC',
            'PANTECH',
            'PARLA',
            'PHILIPS',
            'PLUM',
            'POSH',
            'PRESTIGIO',
            'QMOBILE',
            'QTEK',
            'SAGEM',
            'SAMSUNG',
            'SENDO',
            'SEWON',
            'SHARP',
            'SIEMENS',
            'SONIM',
            'SONY',
            'SONY ERICSSON',
            'SPICE',
            'T-MOBILE',
            'TEL.ME.',
            'TELIT',
            'THURAYA',
            'TOSHIBA',
            'UNNECTO',
            'VERTU',
            'VERYKOOL',
            'VIVO',
            'VK MOBILE',
            'VODAFONE',
            'WIKO',
            'WND',
            'XCUTE',
            'XIAOMI',
            'XOLO',
            'YEZZ',
            'YOTA',
            'YU',
            'ZTE',
        ];

        $letters = [
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'q',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '0',
        ];

        foreach ($brands as $search) {
            foreach ($letters as $letter) {
                try {
                    $devices = $fonoapi::getDevice("$search $letter"); // the device you need to get details here

                    foreach ($devices as $mobile) {
                        MobilePhoneModel::insert(['model' => $mobile->DeviceName, 'manufacturer' => $mobile->Brand]);
                    }
                } catch (Exception $e) {
                }
            }
        }
    }
}
