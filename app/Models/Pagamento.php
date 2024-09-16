<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'fornecedor_id',
        'contrato',
        'vencimento',
        'responsavel',
        'parcela',
        'nota_fiscal',
        'valor',
        'data_pagamento',
        'data_manutencao',
        'status_manutencao',
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
}
