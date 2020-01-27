<?php

namespace App\Library\Services;


use App\Exceptions\VerificationException;
use Illuminate\Http\Request;
use App\Http\Requests\VerifRequest;
use App\Http\Requests\InitVerifRequest;
use Nexmo\Client\Credentials\Basic;
use Nexmo\Client;
use Nexmo\Verify\Verification;


class NexmoVerification
{
    /**
     * @var string
     */
    private $api_key;

    /**
     * @var string
     */
    private $api_secret;

    /**
     * NexmoVerification constructor.
     */
    public function __construct()
    {
        $this->api_key = config('verification.nexmo_api.key');
        $this->api_secret = config('verification.nexmo_api.secret');
    }

    /**
     * Send the verification code to mobile device.
     *
     * @param InitVerifRequest $request
     * @return string
     * @throws VerificationException
     */
    public function request(Request $request): String
    {
        $client = new Client(new Basic($this->api_key, $this->api_secret));
        $validated = $request->validated();
        $verification = new Verification($request->get('number'), 'Morder Inc');

        if($verification == false){
            throw new VerificationException();
        }

        $client->verify()->start($verification);

        return $verification->getRequestId();
    }

    /**
     * Verify the code.
     *
     * @param VerifRequest $request
     * @return ResponseData
     * @throws VerificationException
     */
    public function verify(VerifRequest $request): ResponseData
    {
        $client = new Client(new Basic($this->api_key, $this->api_secret));
        $verification = new Verification($request->get('request_id'));

        if($verification == false){
            throw new VerificationException();
        }

        $result = $client->verify()->check($verification, $request->get('code'));

        return $result->getResponseData();
    }
}
