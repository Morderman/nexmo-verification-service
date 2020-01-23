<?php

namespace App\Library\Services;

use Illuminate\Http\Request;
use App\Http\Requests\InitVerifRequest;
use Response;


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
     * @return \Illuminate\Http\JsonResponse
     */
    public function request(InitVerifRequest $request)
    {
        $basic  = new \Nexmo\Client\Credentials\Basic($this->api_key, $this->api_secret);
        $client = new \Nexmo\Client(new \Nexmo\Client\Credentials\Container($basic));
        $validated = $request->validated();
        $verification = new \Nexmo\Verify\Verification($request->get('number'), 'Morder Inc');
        $client->verify()->start($verification);
        echo "Started verification, `request_id` is " . $verification->getRequestId();
    }

    /**
     * Verify the code.
     *
     * @param Request $request
     * @throws \Exception
     */
    public function verify(Request $request)
    {
        error_log('Verifying code ' . $request->get('code') . ' is correct for request ' . $request->get('request_id'));
        $basic  = new \Nexmo\Client\Credentials\Basic($this->api_key, $this->api_secret);
        $client = new \Nexmo\Client(new \Nexmo\Client\Credentials\Container($basic));
        $verification = new \Nexmo\Verify\Verification($request->get('request_id'));
        $result = $client->verify()->check($verification, $request->get('code'));
        var_dump($result->getResponseData());

        return $result->getResponseData();
    }
}
