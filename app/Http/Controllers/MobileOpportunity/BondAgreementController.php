<?php

namespace App\Http\Controllers\MobileOpportunity;


use App\Helpers\AdobeSign;
use App\Helpers\AdobeSignProvider;
use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Contact;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFileType;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\FulfilmentTimeLineItem;
use App\Models\MobileOpportunity\MobileOpportunity;
use Barryvdh\Snappy\Facades\SnappyPdf;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BondAgreementController extends Controller
{
    protected $client;

    public function store(Customer $customer, MobileOpportunity $opportunity)
    {
        list($valid, $contact) = $this->validateBond();

        if (!$valid) {
            return redirect()->back();
        }

        $opportunity->update([
            'mobile_opportunity_status_id' => (new MobileOpportunityStatusHelper)->get('awaiting-bond-payment'),
            'bg_ref'                       => request()->get('bgRef'),
            'bond_amount'                  => request()->get('amount'),
            'bond_type'                    => request()->get('type'),
        ]);

        if (request()->get('type') == 2) {
            if (auth()->user()->needsAdobeSignAccessTokenRefresh()) {
                alert()->error('Request timed out, please log back into Adobe Sign');

                return redirect()->back();
            }

            FulfilmentTimeLineItem::create([
                'action'                => 'Bond Agreement Sent',
                'mobile_opportunity_id' => $opportunity->id,
                'user_id'               => auth()->user()->id,
            ]);

            list($name, $path) = $this->createPdf($customer, $opportunity);

            $this->setClient();

            try {

                $document = $this->createDocument($name, $path);

                $response = $this->createAgreement($document, $contact);

                $opportunity->adobeSignDocument()->create([
                    'agreement_id' => $response['agreementId'],
                    'status'       => 'OUT_FOR_SIGNATURE',
                    'type'         => 'bond-agreement'
                ]);

                alert()->success('Bond Agreement has been sent via adobe sign, check back later.',
                    'Bond Agreement Sent');

            } catch (\Exception $e) {

                alert()->error('Please try again, if this persists, contact support quoting: ' . $e->getMessage(),
                    'An Error occurred')->confirmButton();
            }
        } else {
            FulfilmentTimeLineItem::create([
                'action'                => 'Bond Agreement Required',
                'mobile_opportunity_id' => $opportunity->id,
                'user_id'               => auth()->user()->id,
            ]);

            alert()->success('Bond Agreement Processed');
        }

        return redirect()->back();
    }

    public function update(Customer $customer, MobileOpportunity $opportunity)
    {
        if (auth()->user()->needsAdobeSignAccessTokenRefresh()) {
            alert()->error('Request timed out, please log back into Adobe Sign');

            return redirect()->back();
        }

        try {
            $this->setClient();

            $response = $this->client->getAgreementCombinedDocument($opportunity->adobeSignDocumentBondAgreement->agreement_id);

            if ($response) {
                $fileType = CustomerFileType::where('slug', 'bond_agreement')->first();

                $file = $customer->files()->create([
                    'related_type'          => 'mobileOpportunity',
                    'related_id'            => $opportunity->id,
                    'customer_file_type_id' => $fileType->id,
                ]);

                $name = "$fileType->slug-$file->id.pdf";

                $path = "$customer->id/$fileType->slug/$name";

                $file->update([
                    'location' => $path
                ]);

                Storage::put($path, $response);

                alert()->success('Bond Agreement Downloaded');
            }
        } catch (\Exception $e) {
            alert()->error('Please try again, if this persists, contact support quoting: ' . $e->getMessage(),
                'An Error occurred');
        }

        return redirect()->back();
    }

    public function createAgreement($response, $contact)
    {
        $data = [
            'documentCreationInfo' => [
                'fileInfos'         => [
                    'transientDocumentId' => $response['transientDocumentId']
                ],
                'name'              => 'Win Win Bond Agreement',
                'recipientSetInfos' => [
                    'recipientSetMemberInfos' => [
                        'email' => $contact->email_address,
                    ],
                    'recipientSetRole'        => 'SIGNER',
                ],
                'callbackInfo'      => 'https://atlas.winwincr.co.uk/oauth2/adobe-sign/status',
                'reminderFrequency' => 'DAILY_UNTIL_SIGNED',
                'signatureType'     => 'ESIGN',
                'signatureFlow'     => 'SENDER_SIGNATURE_NOT_REQUIRED',
                'ccs'               => 'contracts@winwincr.co.uk'
            ],
        ];

        return $this->client->createAgreement($data);
    }

    public function createPdf(Customer $customer, MobileOpportunity $opportunity)
    {
        $fileType = CustomerFileType::where('slug', 'unsigned_bond_agreement')->first();

        $file = $customer->files()->create([
            'related_type'          => 'mobileOpportunity',
            'related_id'            => $opportunity->id,
            'customer_file_type_id' => $fileType->id,
        ]);

        $name = "$fileType->slug-$file->id.pdf";
        $path = "$customer->id/$fileType->slug/$name";

        $file->update([
            'location' => $path
        ]);

        SnappyPdf::loadView('mobile.opportunities.pdf.bond-agreement', [
            'amount'      => request()->get('amount'),
            'bgRef'       => request()->get('bgRef'),
            'customer'    => $customer,
            'opportunity' => $opportunity,
        ])
                 ->setOption('margin-bottom', 0)
                 ->setOption('margin-top', 0)
                 ->setOption('margin-left', 0)
                 ->setOption('margin-right', 0)
                 ->save(storage_path("app/$path"));

        return [
            $name,
            $path
        ];
    }

    public function createDocument($name, $path)
    {
        $data = new MultipartStream([
            [
                'name'     => 'File',
                'contents' => fopen(storage_path("app/$path"), 'r')
            ],
            [
                'name'     => 'File-Name',
                'contents' => $name
            ]
        ]);

        return $this->client->uploadTransientDocument($data);
    }

    public function setClient()
    {
        $provider = new AdobeSignProvider(config('adobe-sign'));

        $client = new AdobeSign($provider);

        $client->setAccessToken(auth()->user()->adobeSignAccessToken->access_token);

        $this->client = $client;
    }

    public function validateBond()
    {
        $validator = Validator::make(request()->all(), [
            'amount' => 'required',
            'bgRef'  => 'required',
        ]);

        if ($validator->fails()) {
            alert()->error('The bond amount needs to be greater than 0');

            return [false, null];
        }

        $contact = Contact::find(request()->get('contact'));

        $validator = Validator::make($contact->toArray(), [
            'email_address' => 'required|email',
        ]);

        if (!$contact || $validator->fails()) {
            alert()->error('This is not a valid contact, please check the email address');

            return [false, null];
        }

        return [true, $contact];
    }
}
