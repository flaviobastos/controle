<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    // Defina explicitamente o nome correto da tabela
    protected $table = 'fornecedores';

    protected $fillable = [
        'fornecedor',
        'objeto',
        'cnpj',
    ];

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }
}
