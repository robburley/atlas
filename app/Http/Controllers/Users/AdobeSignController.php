<?php

namespace App\Http\Controllers\Users;


use App\Helpers\AdobeSign;
use App\Helpers\AdobeSignProvider;
use App\Helpers\FixedLineOpportunityStatusHelper;
use App\Helpers\MobileOpportunityStatusHelper;
use App\Http\Controllers\Controller;
use App\Models\MobileOpportunity\AdobeSignDocument;
use App\Models\MobileOpportunity\MobileOpportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class AdobeSignController extends Controller
{
    public $adobeSign;

    public function __construct()
    {
        $provider = new AdobeSignProvider(config('adobe-sign'));

        $this->adobeSign = new AdobeSign($provider);
    }

    public function store()
    {
        if (auth()->user()->needsAdobeSignAccessToken()) {
            if (request()->has('code')) {
                try {
                    $response = $this->adobeSign->getAccessToken(request()->get('code'));

                    auth()->user()->adobeSignAccessToken()->create([
                        'access_token'  => $response->getToken(),
                        'refresh_token' => $response->getRefreshToken(),
                        'expires'       => $response->getExpires(),
                    ]);

                    return redirect(Cookie::get('atlas-last-url', '/'));
                } catch (InvalidArgumentException $e) {
                    return $this->adobeSign->authorize();
                }
            }

            return $this->adobeSign->authorize();
        }

        if (auth()->user()->needsAdobeSignAccessTokenRefresh()) {
            $response = $this->adobeSign->refreshAccessToken(auth()->user()->adobeSignAccessToken->refresh_token);

            auth()->user()->adobeSignAccessToken->update([
                'access_token' => $response->getToken(),
                'expires'      => $response->getExpires(),
            ]);
        }

        return redirect(Cookie::get('atlas-last-url', '/'));
    }

    public function update()
    {
        $document = AdobeSignDocument::where('agreement_id', request()->get('documentKey'))->firstOrFail();

        $document->update([
            'status' => request()->get('status')
        ]);

        if (request()->get('status') == 'SIGNED') {
            $opportunity = $document->signable;

            $opportunity->processAdobeSign();
        }

        return request()->all();
    }
}
