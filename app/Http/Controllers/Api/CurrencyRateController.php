<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;

class CurrencyRateController extends Controller
{
    protected $currencyRateService;

    public function __construct(CurrencyService $currencyRateService)
    {
        $this->currencyRateService = $currencyRateService;
    }

    // Метод для обновления курсов через API
    // если зачем-то на внещний крон вешать нужно
    public function updateRates(): JsonResponse
    {
        try {
            $this->currencyRateService->fetchRates();
            return response()->json(['status' => 'success', 'message' => 'Currency rates updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
