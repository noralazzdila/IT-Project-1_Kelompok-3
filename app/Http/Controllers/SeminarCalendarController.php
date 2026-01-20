<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class SeminarCalendarController extends Controller
{
    private function calendarService()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-calendar.json'));
        $client->addScope(Calendar::CALENDAR);

        return new Calendar($client);
    }

    public function insertSeminar($seminar)
    {
        $service = $this->calendarService();

        $event = new Event([
            'summary' => 'Seminar PKL - '.$seminar->mahasiswa->nama,
            'description' =>
                "Judul: {$seminar->judul}\n".
                "Dosen Pembimbing: {$seminar->dosen->nama}\n".
                "Tempat: {$seminar->ruangan}",
            'start' => [
                'dateTime' => $seminar->tanggal.'T'.$seminar->jam_mulai,
                'timeZone' => 'Asia/Jakarta',
            ],
            'end' => [
                'dateTime' => $seminar->tanggal.'T'.$seminar->jam_selesai,
                'timeZone' => 'Asia/Jakarta',
            ],
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 1440], // H-1
                    ['method' => 'popup', 'minutes' => 30],
                ],
            ],
        ]);

        $service->events->insert(
            env('GOOGLE_CALENDAR_ID'),
            $event
        );
    }
}
