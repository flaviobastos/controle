<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato',
        'fornecedor',
        'objeto',
        'cnpj',
    ];

    public function pagamento()
    {
        return $this->hasMany(Pagamento::class);
    }

}
