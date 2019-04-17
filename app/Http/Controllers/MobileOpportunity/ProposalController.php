<?php

namespace App\Http\Controllers\MobileOpportunity;

use App\Http\Controllers\Controller;
use App\Mail\ProposalGenerated;
use App\Models\Customer\Contact;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFile;
use App\Models\Customer\CustomerFileType;
use App\Models\MobileOpportunity\DealCalculator\DealCalculator;
use App\Models\MobileOpportunity\MobileOpportunity;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Customer $customer, MobileOpportunity $opportunity, Request $request)
    {
        if ($request->has('contact')) {
            $contact = Contact::find($request->get('contact'));

            if (!$contact) {
                if (!$request->wantsJson()) {
                    alert()->error('Please select a contact to send the purchase order to');

                    return redirect()->back();
                }

                return response()->json(['error' => 'Please select a contact to send the purchase order to'], 442);
            }

            $validator = Validator::make($contact->toArray(), [
                'email_address' => 'required|email',
            ]);

            if ($validator->fails()) {
                if (!$request->wantsJson()) {
                    alert()->error('This is not a valid contact, please check the email address');

                    return redirect()->back();
                }

                return response()->json(
                    ['error' => 'This is not a valid contact, please check the email address'],
                    442
                );
            }
        }

        $dealCalculator = DealCalculator::with([
            'creator',
            'accessories',
            'contributions',
            'credits',
            'handsets',
            'primaryConnections',
            'secondaryConnections',
            'overview',
        ])->findOrFail($request->get('deal_calc'));

        $fileType = CustomerFileType::where('slug', 'proposal')->first();

        $path = "$customer->id/$fileType->slug/$fileType->slug-$dealCalculator->id.pdf";

        if (!CustomerFile::where('location', $path)->first()) {
            $customer->files()->create([
                'related_type'          => 'mobileOpportunity',
                'related_id'            => $opportunity->id,
                'customer_file_type_id' => $fileType->id,
                'location'              => $path
            ]);

            SnappyPdf::loadView('mobile.opportunities.pdf.proposal', [
                'dealCalculator' => $dealCalculator,
                'customer'       => $customer,
                'opportunity'    => $opportunity,
            ])
                     ->setPaper('a4')
                     ->setOption('dpi', 96)
                     ->setOption('margin-bottom', 0)
                     ->setOption('margin-top', 0)
                     ->setOption('margin-left', 0)
                     ->setOption('margin-right', 0)
                     ->save(storage_path("app/$path"));
        }

        if (!$request->has('contact')) {
            if (!$request->wantsJson()) {
                alert()->success('Proposal generated');
            }

            return $request->wantsJson()
                ? response()->json(['success' => 'Proposal sent generated'], 200)
                : redirect()->back();
        }

        try {
            Mail::to($contact->email_address)
                ->send(new ProposalGenerated(
                    $opportunity,
                    storage_path("app/$path"),
                    $contact,
                    request()->get('message')
                ));

            if (!$request->wantsJson()) {
                alert()->success('Proposal sent to ' . $contact->full_name);
            }
        } catch (\Exception $e) {
            if (!$request->wantsJson()) {
                alert()->error('There is a problem with your account, please contact support. ' . $e->getMessage());
            }

            return response()->json(
                'There is a problem with your account, please contact support. ' . $e->getMessage(),
                442
            );
        }

        return $request->wantsJson()
            ? response()->json(['success' => 'Proposal sent to ' . $contact->full_name], 200)
            : redirect()->back();
    }
}
