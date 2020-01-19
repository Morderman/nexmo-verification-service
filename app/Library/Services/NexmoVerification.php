<?php

namespace App\Library\Services;

use Illuminate\Http\Request;
use Validator;
use Response;


class NexmoVerification
{
    /**
     * Send the verification code to mobile device.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function request(Request $request)
    {
        $basic  = new \Nexmo\Client\Credentials\Basic(NEXMO_API_KEY, NEXMO_API_SECRET);
        $client = new \Nexmo\Client(new \Nexmo\Client\Credentials\Container($basic));
        $validator = Validator::make($request->all(), [
            'number' => 'required|regex:/(380)[0-9]{9}/',
        ]);
        if ($validator->fails()) {
            echo "it failed";
            return response()->json($validator->errors());
        }
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
        $basic  = new \Nexmo\Client\Credentials\Basic(NEXMO_API_KEY, NEXMO_API_SECRET);
        $client = new \Nexmo\Client(new \Nexmo\Client\Credentials\Container($basic));
        $verification = new \Nexmo\Verify\Verification($request->get('request_id'));
        $result = $client->verify()->check($verification, $request->get('code'));
        var_dump($result->getResponseData());

        return $result->getResponseData();
    }
}
