<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailDeVerificacaoNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    public const ROLE_ENUM = [
        "admin"                      => "admin",
        "chefeSetorConcursos"        => "chefeSetorConcursos",
        "presidenteBancaExaminadora" => "presidenteBancaExaminadora",
        "candidato"                  => "candidato",
    ];

    public static $rules = [
        'email'                      => 'required|email|min:5|max:100|unique:users',
        'password'                   => 'required|string|min:8|confirmed',
        'nome'                       => 'required|string|min:4|max:50',
        'sobrenome'                  => 'required|string|min:4|max:50',
        'nome_do_pai'                => 'nullable|string|min:8|max:100',
        'nome_da_mãe'                => 'required|string|min:8|max:100',
        'data_de_nascimento'         => 'required|date',
        'país_de_origem'             => 'required',
        'estrangeiro'                => 'required',
        'documento_de_identificação' => 'required|string|min:8|max:50',
        'órgao_emissor'              => 'required_if:estrangeiro,não',
        'cpf'                        => 'required_if:estrangeiro,não|cpf|min:11|max:12|unique:candidatos',
        'telefone'                   => 'nullable|min:10|max:20',
        'celular'                    => 'required|min:10|max:20',
        'cep'                        => 'required',
        'logradouro'                 => 'required|min:4|max:100',
        'bairro'                     => 'required|min:4|max:100',
        'número'                     => 'required|min:1|max:100',
        'cidade'                     => 'required|min:4|max:100',
        'uf'                         => 'required',
        'complemento'                => 'nullable|min:2|max:150',
    ];

    public static $rulesAdmin = [
        'nome'      => 'required|string|min:4|max:50',
        'sobrenome' => 'required|string|min:4|max:50',
        'email'     => 'required|email|min:5|max:100|unique:users',
        'role'      => 'required|in:admin,chefeSetorConcursos,presidenteBancaExaminadora,candidato',
        'password'  => 'required|string|min:8|confirmed',
        'concurso'  => 'required_if:role,presidenteBancaExaminadora',
    ];

    public static $messages = [
        'nome.required'             => 'O nome é um campo obrigatório.',
        'nome.min'                  => 'O nome deve ter no mínimo 4 caracteres.',
        'nome.max'                  => 'O nome deve ter no máximo 50 caracteres.',
        'sobrenome.required'        => 'O sobrenome é um campo obrigatório.',
        'sobrenome.min'             => 'O sobrenome deve ter no mínimo 4 caracteres.',
        'sobrenome.max'             => 'O sobrenome deve ter no máximo 50 caracteres.',
        'email.required'            => 'O e-mail é um campo obrigatório.',
        'email.min'                 => 'O e-mail deve ter no mínimo 5 caracteres.',
        'email.max'                 => 'O e-mail deve ter no máximo 100 caracteres.',
        'email.unique'              => 'Este e-mail já está sendo usado.',
        'role.*'                    => 'Tipo de usuário inválido',
        'password.required'         => 'A senha é um campo obrigatório.',
        'password.min'              => 'A senha deve ter no mínimo 8 caracteres.',
        'password.confirmed'        => 'As senhas devem ser iguais.',
        'concurso.required_if'      => 'Escolha o concurso a qual o chefe da banca pertencerá.',
        'cpf.required_if'           => 'O campo CPF é obrigatório quando não for estrangeiro.',
        'cpf.unique'                => 'Esse CPF já está cadastrado.',
        'órgao_emissor.required_if' => 'O órgão emissor é obrigatório quando não for estrangeiro.',
        'país_de_origem.required'   => 'O campo país de origem é obrigatório.',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'sobrenome',
        'email',
        'password',
        'concursos_id',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function concursos()
    {
        return $this->hasMany(Concurso::class, 'users_id');
    }

    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'users_id');
    }

    public function concursosChefeBanca()
    {
        return $this->belongsToMany(Concurso::class, 'chefe_da_banca', 'users_id', 'concursos_id')->withPivot('chefe');
    }

    public function candidato()
    {
        return $this->hasOne(Candidato::class, 'users_id');
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'users_id');
    }

    public function sendEmailVerificationNotification()
    {
        Notification::send($this, new EmailDeVerificacaoNotification($this));
    }
}
