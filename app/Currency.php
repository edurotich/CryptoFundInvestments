<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Currency extends Model
{
    protected $fillable = ['name', 'symbol', 'currency_type_id', 'coin_market_cap_id'];

    public function type() {
        return $this->hasOne('App\CurrencyType', 'id', 'currency_type_id');
    }

    public function getIdBySymbol($symbol) {
        return $this->where('symbol', $symbol)->id;
    }

    public function latestCoinPrice(){
        return $this->hasOne('App\CoinPrice', 'currency_id', 'id')->latest();
    }

    public function coinPriceByTimestamp($ts){
        return $this->hasOne('App\CoinPrice', 'currency_id', 'id')
            ->where('created_at', '<', Carbon::createFromTimestamp($ts)->toDateTimeString())
            ->orderByDesc('created_at')
            ->first();
    }
}
