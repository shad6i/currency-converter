<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\CurrencyRate;
use Exception;

class CurrencyService
{
    protected $client;
    protected $apiUrl = 'https://api.freecurrencyapi.com/v1/latest';
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('CURRENCY_API_KEY');
    }

    // Метод для загрузки курсов валют с API и сохранения их в базу данных
    public function fetchRates()
    {
        try {
            $response = $this->client->get($this->apiUrl, [
                'query' => [
                    'apikey' => $this->apiKey
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            \Log::info($data);

            if (isset($data['data'])) {
                foreach ($data['data'] as $currencyCode => $rate) {
                    CurrencyRate::updateOrCreate(
                        ['currency_code' => $currencyCode],
                        ['rate' => $rate]
                    );
                }
            }
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    // Метод для конвертации валют
    public function convert($amount, $fromCurrency, $toCurrency)
    {
        $fromRate = CurrencyRate::where('currency_code', $fromCurrency)->first();
        $toRate = CurrencyRate::where('currency_code', $toCurrency)->first();

        if (!$fromRate || !$toRate) {
            throw new Exception("Currency not found.");
        }

        $baseAmount = $amount / $fromRate->rate;
        return $baseAmount * $toRate->rate;
    }
}
