<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class VideoCallController extends Controller
{
    public function generateToken(Request $request)
    {
        $identity = $request->input('identity');
        $roomName = $request->input('room');

        $accountSid = env('TWILIO_ACCOUNT_SID');
        $apiKeySid = env('TWILIO_API_KEY_SID');
        $apiKeySecret = env('TWILIO_API_KEY_SECRET');

        if (!$accountSid || !$apiKeySid || !$apiKeySecret) {
            return response()->json(['error' => 'Twilio credentials are missing'], 500);
        }

        try {
            $token = new AccessToken(
                $accountSid,
                $apiKeySid,
                $apiKeySecret,
                3600,
                $identity
            );

            $videoGrant = new VideoGrant();
            $videoGrant->setRoom($roomName);

            $token->addGrant($videoGrant);

            return response()->json(['token' => $token->toJWT()]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error generating Twilio token: ' . $e->getMessage()], 500);
        }
    }
}
