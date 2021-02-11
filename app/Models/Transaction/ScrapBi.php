<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class ScrapBi extends Model
{

    protected $table = 'scrap_bi';
    public $timestamps = false;
    protected $fillable = ['id_m_currency', 'id_m_bank', 'rate_sell', 'rate_buy', 'rate_middle', 'date', 'notes'];

}
