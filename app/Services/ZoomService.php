<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZoomService
{
    private function getAccessToken()
    {
        $response = Http::asForm()
            ->withHeaders([
                'Authorization' => 'Basic ' . base64_encode(
                    env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET')
                ),
            ])
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => env('ZOOM_ACCOUNT_ID'),
            ]);

        if ($response->failed()) {
            throw new \Exception('Zoom Auth Failed: ' . $response->body());
        }

        return $response->json()['access_token'];
    }

    public function createMeeting($topic, $startTime, $duration = 30, $agenda = '')
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->post('https://api.zoom.us/v2/users/me/meetings', [
                'topic' => $topic,
                'type' => 2, // scheduled
                'start_time' => $startTime,
                'duration' => $duration,
                'agenda' => $agenda,
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'waiting_room' => true,
                ],
            ]);

        if ($response->failed()) {
            throw new \Exception('Zoom Meeting Creation Failed: ' . $response->body());
        }

        return $response->json();
    }
}