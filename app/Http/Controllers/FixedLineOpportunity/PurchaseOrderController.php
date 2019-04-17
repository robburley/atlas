<?php

namespace App\Http\Controllers\FixedLineOpportunity;


use App\Helpers\AdobeSign;
use App\Helpers\AdobeSignProvider;
use App\Http\Controllers\Controller;
use App\Models\Customer\Contact;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFileType;
use App\Models\FixedLineOpportunity\FixedLineOpportunity;
use Barryvdh\Snappy\Facades\SnappyPdf;
use GuzzleHttp\Psr7\MultipartStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    protected $client;

    public function store(Customer $customer, FixedLineOpportunity $opportunity, Request $request)
    {
        if (auth()->user()->needsAdobeSignAccessTokenRefresh()) {
            alert()->error('Request timed out, please log back into Adobe Sign');

            return redirect()->back();
        }

        $contact = Contact::find($request->get('contact'));

        $validator = Validator::make($contact->toArray(), [
            'email_address' => 'required|email',
        ]);

        if (!$contact || $validator->fails()) {
            alert()->error('This is not a valid contact, please check the email address');

            return redirect()->back();
        }

        list($name, $path) = $this->createPdf($customer, $opportunity, $request);

        $this->setClient();

        try {

            $document = $this->createDocument($name, $path);

            $response = $this->createAgreement($document, $contact);

            $opportunity->adobeSignDocument()->create([
                'agreement_id' => $response['agreementId'],
                'status'       => 'OUT_FOR_SIGNATURE',
                'type'         => 'purchase-order'
            ]);

            alert()->success('Purchase order has been sent via adobe sign, check back later.', 'Purchase Order Sent');

        } catch (\Exception $e) {

            alert()->error('Please try again, if this persists, contact support quoting: ' . $e->getMessage(),
                'An Error occurred')->confirmButton();
        }

        return redirect()->back();
    }

    public function update(Customer $customer, FixedLineOpportunity $opportunity)
    {
        if (auth()->user()->needsAdobeSignAccessTokenRefresh()) {
            alert()->error('Request timed out, please log back into Adobe Sign');

            return redirect()->back();
        }

        try {
            $this->setClient();

            $response = $this->client->getAgreementCombinedDocument($opportunity->adobeSignDocumentPurchaseOrder->agreement_id);

            if ($response) {
                $fileType = CustomerFileType::where('slug', 'purchase_order')->first();

                $file = $customer->files()->create([
                    'related_type'          => 'fixedLineOpportunity',
                    'related_id'            => $opportunity->id,
                    'customer_file_type_id' => $fileType->id,
                ]);

                $name = "$fileType->slug-$file->id.pdf";

                $path = "$customer->id/$fileType->slug/$name";

                $file->update([
                    'location' => $path
                ]);

                Storage::put($path, $response);

                alert()->success('Purchase Order Downloaded');
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
                'name'              => 'Win Win Purchase Order',
                'recipientSetInfos' => [
                    'recipientSetMemberInfos' => [
                        'email' => $contact->email_address,
                    ],
                    'recipientSetRole'        => 'SIGNER',
                ],
                'callbackInfo'      => 'https://atlas.winwincr.co.uk/oauth2/adobe-sign/status',
                'reminderFrequency' => 'DAILY_UNTIL_SIGNED',
                'signatureType'     => 'ESIGN',
                'signatureFlow'     => 'SENDER_SIGNATURE_NOT_REQUIRED'
            ],
        ];

        return $this->client->createAgreement($data);
    }

    public function createPdf(Customer $customer, FixedLineOpportunity $opportunity, Request $request)
    {
        $fileType = CustomerFileType::where('slug', 'unsigned_purchase_order')->first();

        $file = $customer->files()->create([
            'related_type'          => 'fixedLineOpportunity',
            'related_id'            => $opportunity->id,
            'customer_file_type_id' => $fileType->id,
        ]);

        $name = "$fileType->slug-$file->id.pdf";
        $path = "$customer->id/$fileType->slug/$name";

        $file->update([
            'location' => $path
        ]);

        SnappyPdf::loadView('fixed-line.opportunities.pdf.purchase-order', [
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
}
