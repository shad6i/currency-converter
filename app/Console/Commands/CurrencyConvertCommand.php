<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CurrencyService;
use App\Models\CurrencyRate;

class CurrencyConvertCommand extends Command
{
    protected $signature = 'currency:convert {amount?} {from?} {to?} {--currencies}';
    protected $description = 'Конвертировать валюту или вывести список доступных валют';

    protected CurrencyService $currencyConverter;

    public function __construct(CurrencyService $currencyConverter)
    {
        parent::__construct();
        $this->currencyConverter = $currencyConverter;
    }

    public function handle(): void
    {
        if ($this->option('currencies')) {
            $this->listCurrencies();
            return;
        }

        $amount = $this->argument('amount');
        $from = $this->argument('from');
        $to = $this->argument('to');

        if (!$amount || !$from || !$to) {
            $this->error('Пожалуйста, укажите сумму, исходную и целевую валюты.');
            return;
        }

        try {
            $convertedAmount = $this->currencyConverter->convert($amount, $from, $to);
            $this->info("Converted: {$amount} {$from} = {$convertedAmount} {$to}");
        } catch (\Exception $e) {
            $this->error('Ошибка при конвертации: ' . $e->getMessage());
        }
    }

    protected function listCurrencies(): void
    {
        $currencies = CurrencyRate::all();

        if ($currencies->isEmpty()) {
            $this->warn('В базе данных нет доступных валют.');
            return;
        }

        $this->info('Доступные валюты:');
        foreach ($currencies as $currency) {
            $this->line($currency->currency_code . ' - ' . $currency->rate);
        }
    }
}
