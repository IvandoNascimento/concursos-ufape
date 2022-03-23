<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;

    protected $table = 'inscricoes';

    public const titulacao_ENUM = ["graduacao", "especializacao", "mestrado", "doutorado"];

    public static $rules = [
        'titulacao'         => 'required|in:graduacao,especializacao,mestrado,doutorado',
        'cotista'           => 'required|in:true,false',
        'area_conhecimento' => 'required|string|min:5|max:100',
        'pcd'               => 'required|in:true,false'
    ];

    public static $messages = [
        'titulacao.*'                => 'Titulação inválida.',
        'cotista.required'           => 'O campo de Cota é obrigatório.',
        'area_conhecimento.required' => 'A campo de Área de conhecimento é obrigatório',
        'area_conhecimento.min'      => 'A Área de conhecimento deve ter no mínimo 5 caracteres.',
        'area_conhecimento.max'      => 'A Área de conhecimento deve ter no máximo 100 caracteres.',
        'pcd.required'               => 'O campo de PCD é obrigatório.'
    ];

    protected $fillable = [
        'status',
        'cotista',
        'solicitou_isencao',
        'pcd',
        'users_id',
        'concursos_id',
        'vagas_id',
    ];

    public function concurso()
    {
        return $this->belongsTo(Concurso::class, 'concursos_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function vaga()
    {
        return $this->belongsTo(OpcoesVagas::class, 'vagas_id');
    }

    public function avaliacao()
    {
        return $this->hasOne(Avaliacao::class, 'inscricoes_id');
    }

    public function arquivos()
    {
        return $this->hasOne(Arquivo::class, 'inscricoes_id');
    }

    public function avaliacaoEfetivo()
    {
        return $this->hasOne(AvaliacaoEfetivo::class, 'inscricao_id');
    }
}
