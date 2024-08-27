<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_id',
        'vencimento',
        'responsavel',
        'parcela',
        'nota_fiscal',
        'valor',
        'data_pagamento',
        'data_manutencao',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
