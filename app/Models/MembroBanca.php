<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembroBanca extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaga_id',
        'user_id',
        'concurso_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vaga()
    {
        return $this->belongsTo(OpcoesVagas::class, 'vaga_id');
    }
}
