<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use App\Models\User;

class GoogleCalendarService
{
    protected $client;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $this->client = $client;
    }

    public function createEventForUser(User $user, $seminar)
    {
        if (!$user->google_refresh_token) {
            return; // Or throw an exception
        }

        $this->client->setAccessToken([
            'access_token' => $user->google_access_token,
            'refresh_token' => $user->google_refresh_token,
            'expires_in' => 3599 // Default value, will be updated if token is refreshed
        ]);

        // Refresh the token if it's expired
        if ($this->client->isAccessTokenExpired()) {
            $newAccessToken = $this->client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
            $user->google_access_token = $newAccessToken['access_token'];
            $user->save();
            $this->client->setAccessToken($newAccessToken);
        }

        $calendar = new Google_Service_Calendar($this->client);

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Seminar Proposal: ' . $seminar->judul,
            'description' => 'Seminar proposal dengan judul "' . $seminar->judul . '" telah dijadwalkan.',
            'start' => [
                'dateTime' => $seminar->tanggal->toRfc3339String(),
                'timeZone' => 'Asia/Jakarta',
            ],
            'end' => [
                'dateTime' => $seminar->tanggal->addHours(1)->toRfc3339String(), // Assuming 1 hour duration
                'timeZone' => 'Asia/Jakarta',
            ],
        ]);

        $calendarId = 'primary';
        $calendar->events->insert($calendarId, $event);
    }
}
