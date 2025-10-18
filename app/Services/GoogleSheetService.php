<?php

namespace App\Services;

use App\Models\Nilai;
use Google\Client;
use Google\Service\Sheets;
use Exception;

class GoogleSheetService
{
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        try {
            $client = new Client();
            $client->setApplicationName('Laravel Google Sheets Integration');
            $client->setScopes([Sheets::SPREADSHEETS_READONLY]);
            $client->setAuthConfig(storage_path('app/google/credentials.json'));
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            $this->service = new Sheets($client);

            // 🔑 Ganti dengan ID Spreadsheet kamu
            $this->spreadsheetId = '1aLM27LuVazzY8VitpACu_rTSGjEsRFxiyTxGzl2otxI';
        } catch (Exception $e) {
            throw new Exception("Gagal menginisialisasi Google Client: " . $e->getMessage());
        }
    }

    /**
     * 🧩 Ambil data dari sheet tertentu
     */
    public function getSheetData(string $sheetName): array
    {
        try {
            // ✅ Gunakan tanda kutip jika nama sheet mengandung spasi
            $range = "'{$sheetName}'!B2:H34";
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
            return $response->getValues() ?? [];
        } catch (Exception $e) {
            throw new Exception("Gagal memuat data dari Google Sheets ($sheetName): " . $e->getMessage());
        }
    }

    /**
     * 🚀 Ambil semua data dari seluruh sheet di spreadsheet
     */
    public function getAllSheetsData(): array
    {
        try {
            $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
            $sheets = $spreadsheet->getSheets();

            $allData = [];

            foreach ($sheets as $sheet) {
                $sheetTitle = $sheet->getProperties()->getTitle();

                try {
                    $range = "'{$sheetTitle}'!B2:H34";
                    $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
                    $values = $response->getValues();

                    if (!empty($values)) {
                        $allData[$sheetTitle] = $values;
                    }
                } catch (Exception $e) {
                    // Jika sheet kosong atau range tidak valid, lanjut
                    continue;
                }
            }

            return $allData;
        } catch (Exception $e) {
            throw new Exception('Gagal memuat semua sheet: ' . $e->getMessage());
        }
    }

    /**
     * 📋 Ambil daftar nama semua sheet
     */
    public function getSheetNames(): array
    {
        try {
            $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
            $sheets = $spreadsheet->getSheets();

            $sheetNames = [];
            foreach ($sheets as $sheet) {
                $sheetNames[] = $sheet->getProperties()->getTitle();
            }

            return $sheetNames;
        } catch (Exception $e) {
            throw new Exception('Gagal memuat daftar nama sheet: ' . $e->getMessage());
        }
    }
    
    /**
 * 🎯 Ambil semua data dari sheet berdasarkan nama sheet (tanpa batasan range tetap)
 */
public function getSheetDataByName(string $sheetName): array
{
    try {
        // Ambil semua data (A1:Z1000 supaya fleksibel)
        $range = "'{$sheetName}'!A1:Z1000";
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        return $response->getValues() ?? [];
    } catch (Exception $e) {
        throw new Exception("Gagal memuat data dari sheet {$sheetName}: " . $e->getMessage());
    }
}

public function show($id, GoogleSheetService $sheetService)
{
    $nilai = Nilai::with('mahasiswa')->findOrFail($id);

    // Ambil nama sheet yang disimpan
    $sheetName = $nilai->sheet_name;

    // Ambil data dari Google Sheet
    $rows = $sheetService->getSheetData($sheetName);

    // Buang header
    $dataRows = array_slice($rows, 1);

    // Format baris untuk tabel
    $matkulRows = [];
    foreach ($dataRows as $row) {
        if (count($row) < 6) continue;
        $matkulRows[] = [
            'kode' => $row[1] ?? '-',
            'mata_kuliah' => $row[2] ?? '-',
            'nilai' => $row[3] ?? '-',
            'am' => $row[4] ?? 0,
            'sks' => $row[5] ?? 0,
            'bobot' => ($row[4] ?? 0) * ($row[5] ?? 0),
        ];
    }

    return view('nilai.show', [
        'nilai' => $nilai,
        'rows' => $matkulRows,
        'studentName' => $nilai->mahasiswa->nama,
        'nim' => $nilai->mahasiswa->nim,
        'ipk' => $nilai->ipk,
        'totalSks' => $nilai->total_sks,
    ]);
}

}
