<?php

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\UpdateCurrencyRates;


Schedule::command(UpdateCurrencyRates::class, [])->daily();
