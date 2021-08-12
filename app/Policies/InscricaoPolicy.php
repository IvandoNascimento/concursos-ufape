<?php

namespace App\Policies;

use App\Models\Inscricao;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\HandlesAuthorization;

class InscricaoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inscricao  $inscricao
     * @return mixed
     */
    public function view(User $user, Inscricao $inscricao)
    {
        $concurso = $inscricao->concurso;
        return $user->id == $inscricao->users_id || $concurso->users_id == $user->id || $concurso->chefeDaBanca->contains('id', $user->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return !($user->inscricoes->contains('concursos_id', Route::current()->concurso_id)) && $user->role == User::ROLE_ENUM['candidato'];
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inscricao  $inscricao
     * @return mixed
     */
    public function update(User $user, Inscricao $inscricao)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inscricao  $inscricao
     * @return mixed
     */
    public function delete(User $user, Inscricao $inscricao)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inscricao  $inscricao
     * @return mixed
     */
    public function restore(User $user, Inscricao $inscricao)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inscricao  $inscricao
     * @return mixed
     */
    public function forceDelete(User $user, Inscricao $inscricao)
    {
        //
    }

    /**
     * Determina se a inscrição pode ser vista pelo candidato.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inscricao  $inscricao
     * @return mixed
     */

    public function showDocumentos(User $user, Inscricao $inscricao)
    {
        return $inscricao->users_id == $user->id || $user->role == "chefeSetorConcursos" || $user->role == "admin";
    }

    public function enviarDocumentos(User $user, Inscricao $inscricao)
    {
        return $inscricao->users_id == $user->id && $this->dentroDoPeriodo($inscricao) || $user->role == "chefeSetorConcursos" || $user->role == "admin";
    }

    private function dentroDoPeriodo(Inscricao $inscricao)
    {
        $concurso = $inscricao->concurso;
        return $concurso->data_inicio_envio_doc <= now() && now() <= $concurso->data_fim_envio_doc;
    }
}
