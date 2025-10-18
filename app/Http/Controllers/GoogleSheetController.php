<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetService;
use Exception;

class GoogleSheetController extends Controller
{
    // Endpoint untuk daftar sheet
    public function index(GoogleSheetService $sheetService)
    {
        try {
            $sheetNames = $sheetService->getSheetNames();
            return response()->json($sheetNames);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
