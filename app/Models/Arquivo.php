<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;

    public static $rules = [
        'dados_pessoais'           => 'required|file|mimes:pdf|max:2048',
        'curriculum_vitae_lattes'  => 'required|file|mimes:pdf|max:2048',
        'formacao_academica'       => 'required|file|mimes:pdf|max:2048',
        'experiencia_didatica'     => 'nullable|file|mimes:pdf|max:2048',
        'producao_cientifica'      => 'nullable|file|mimes:pdf|max:2048',
        'experiencia_profissional' => 'nullable|file|mimes:pdf|max:2048',
    ];

    public static $messages = [
        'dados_pessoais.required'           => 'O arquivo de dados pessoais é obrigatório.',
        'dados_pessoais.max'                => 'O tamanho máximo do arquivo de dados pessoais são 15MB.',
        'dados_pessoais.mimes'              => 'O arquivo de dados pessoais só pode ser um PDF.',
        'curriculum_vitae_lattes.required'  => 'O arquivo de currículo lattes é obrigatório.',
        'curriculum_vitae_lattes.max'       => 'O tamanho máximo do arquivo de currículo lattes são 15MB.',
        'curriculum_vitae_lattes.mimes'     => 'O arquivo de currículo lattes só pode ser um PDF.',
        'formacao_academica.required'       => 'O arquivo de formação acadêmica é obrigatório.',
        'formacao_academica.max'            => 'O tamanho máximo do arquivo de formação acadêmica são 15MB.',
        'formacao_academica.mimes'          => 'O arquivo de formação acadêmica só pode ser um PDF.',
        'experiencia_didatica.max'          => 'O tamanho máximo do arquivo de experiência didática são 15MB.',
        'experiencia_didatica.mimes'        => 'O arquivo de experiência didática só pode ser um PDF.',
        'producao_cientifica.max'           => 'O tamanho máximo do arquivo de produção didática são 15MB.',
        'producao_cientifica.mimes'         => 'O arquivo de produção didática só pode ser um PDF.',
        'experiencia_profissional.max'      => 'O tamanho máximo do arquivo de experiência profissional são 15MB.',
        'experiencia_profissional.mimes'    => 'O arquivo de experiência profissional só pode ser um PDF.',
    ];

    public static $efetivo_mensagem = [
        'avaliacao_perfil.required'           => 'O arquivo de compatibilidade do perfil é obrigatório.',
        'avaliacao_perfil.max'                => 'O tamanho máximo do arquivo de compatibilidade do perfil é 15MB.',
        'avaliacao_perfil.mimes'              => 'O arquivo de compatibilidade do perfil só pode ser um PDF.',
    ];

    protected $fillable = [
        'dados_pessoais',
        'curriculum_vitae_lattes',
        'formacao_academica',
        'experiencia_didatica',
        'producao_cientifica',
        'experiencia_profissional',
        'inscricoes_id',
        'avalicao_perfil'
    ];

    public function inscricao()
    {
        return $this->belongsTo(Inscricao::class, 'inscricoes_id');
    }
}
