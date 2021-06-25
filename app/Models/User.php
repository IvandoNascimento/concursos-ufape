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

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    public const ROLE_ENUM = [
        "admin" => "admin",
        "chefeSetorConcursos" => "chefeSetorConcursos",
        "presidenteBancaExaminadora" => "presidenteBancaExaminadora",
        "candidato" => "candidato",
    ];

    public static $rules = [
        'nome' => 'required|string|min:4|max:50',
        'sobrenome' => 'required|string|min:4|max:50',
        'email' => 'required|email|min:5|max:100|unique:users',
        'role' => 'required|in:admin,chefeSetorConcursos,presidenteBancaExaminadora,candidato',
        'password' => 'required|string|min:8|confirmed',
    ];

    public static $messages = [
        'nome.required' => 'O nome é um campo obrigatório.',
        'nome.min' => 'O nome deve ter no mínimo 4 caracteres.',
        'nome.max' => 'O nome deve ter no máximo 50 caracteres.',
        'sobrenome.required' => 'O sobrenome é um campo obrigatório.',
        'sobrenome.min' => 'O sobrenome deve ter no mínimo 4 caracteres.',
        'sobrenome.max' => 'O sobrenome deve ter no máximo 50 caracteres.',
        'email.required' => 'O e-mail é um campo obrigatório.',
        'email.min' => 'O e-mail deve ter no mínimo 5 caracteres.',
        'email.max' => 'O e-mail deve ter no máximo 100 caracteres.',
        'email.unique' => 'Este e-mail já está sendo usado.',
        'role.*' => 'Tipo de usuário inválido',
        'password.required' => 'A senha é um campo obrigatório.',
        'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
        'password.confirmed' => 'As senhas devem ser iguais.',
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

    public function inscricao()
    {
        return $this->hasMany(Inscricao::class, 'inscricao_id');
    }
}
