<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvaliacaoEfetivo extends Model
{
    use HasFactory;

    public const STATUS_ENUM = [
        'deferido'     => 0,
        'indeferido'     => 1,
    ];

    protected $fillable = [
        'status',
        'inscricao_id',
        'concurso_id',
    ];

    public function inscricao()
    {
        return $this->belongsTo(Inscricao::class, 'inscricao_id');
    }

    public function concurso()
    {
        return $this->belongsTo(Concurso::class, 'concurso_id');
    }

    public function getStatusAvaliacao()
    {
        switch ($this->status) {
            case AvaliacaoEfetivo::STATUS_ENUM['deferido']:
                return 'Deferido';
                break;
            case AvaliacaoEfetivo::STATUS_ENUM['indeferido']:
                return 'Indeferido';
                break;
            default:
                break;
        }
    }
}
