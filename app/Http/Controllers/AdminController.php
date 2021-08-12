<?php

namespace App\Http\Controllers;

use App\Models\Concurso;
use App\Models\User;
use App\Notifications\UsuarioCadastradoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $usuarios = User::all()->except(Auth::id());
        return view('usuario.index', compact('usuarios'));
    }

    public function createUser()
    {
        $concursos = auth()->user()->concursos()->where('data_resultado_selecao', '>', now())->get();

        return view('CRUD-usuario.create')->with(['concursos' => $concursos]);
    }

    public function create()
    {
        $concursos = Concurso::where('data_resultado_selecao', '>', now())->get();
        return view('usuario.create',  compact('concursos'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), User::$rulesAdmin, User::$messages)->validate();

        $data = [
            'nome' => $request['nome'],
            'sobrenome' => $request['sobrenome'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => $request['role']
        ];

        $usuario = new User();
        $usuario->fill($data);;
        $usuario->save();

        if ($request->concurso != null && $request->role == "presidenteBancaExaminadora") {
            $usuario->concursosChefeBanca()->attach($request->concurso);
        }

        $usuario->password = $request['password'];

        Notification::send($usuario, new UsuarioCadastradoNotification($usuario));

        return redirect(route('user.index'))->with(['success' => 'Cadastro realizado com sucesso!']);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('usuario.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::find($id);
        $rules = User::$rulesAdmin;
        $messages = User::$messages;

        if (!$request['password']) {
            $rules = array_slice(User::$rules, 0, 3);
            $messages = array_slice(User::$messages, 0, 10);
        }

        $rules['email'] = [
            'required', 'email', 'min:5', 'max:100',
            Rule::unique('users')->ignore($usuario->id),
        ];

        $request['role'] = $usuario->role;

        Validator::make($request->all(), $rules, $messages)->validate();

        $data = [
            'nome' => $request['nome'],
            'sobrenome' => $request['sobrenome'],
            'email' => $request['email'],
        ];

        if ($request['password'])
            $data['password'] = Hash::make($request['password']);

        $usuario->fill($data)->update();

        return redirect(route('user.index'))->with(['success' => 'Usuário editado com sucesso!']);
    }

    public function destroy($id)
    {
        $usuario = User::find($id);

        if ($usuario->concursos->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Não é possivel deletar o usuário pois ele criou concursos.']);
        }
        if ($usuario->inscricoes->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Não é possivel deletar o usuário pois existem inscrições realizadas do mesmo.']);
        }
        if ($usuario->concursosChefeBanca->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Não é possivel deletar o usuário pois ele está vinculado como chefe de banca examinadora em um concurso.']);
        }

        $usuario->delete();

        return redirect(route('user.index'))->with(['success' => 'Usuário deletado com sucesso!']);
    }

    public function usuarioDeBanca($id)
    {
        $concurso = Concurso::find($id);
        $this->authorize('operacoesUserBanca', $concurso);
        
        $usuariosMembros = collect();
        $membrosDoConcurso = $concurso->chefeDaBanca()->orderBy('nome')->get();
        $users = User::where('role', User::ROLE_ENUM["presidenteBancaExaminadora"])->orderBy('nome')->get();

        foreach ($users as $user) {
            if (!$membrosDoConcurso->contains('id', $user->id)) {
                $usuariosMembros->push($user);
            }
        }

        return view('usuario.banca_examinadora', compact('usuariosMembros', 'membrosDoConcurso', 'concurso'));
    }

    public function createUserBanca(Request $request, $id)
    {
        $concurso = Concurso::find($id);
        $this->authorize('operacoesUserBanca', $concurso);
        Validator::make($request->all(), User::$rulesAdmin, User::$messages)->validate();

        $data = [
            'nome' => $request['nome'],
            'sobrenome' => $request['sobrenome'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => $request['role']
        ];

        $usuario = new User();
        $usuario->fill($data);
        $usuario->role = "presidenteBancaExaminadora";
        $usuario->save();

        $usuario->concursosChefeBanca()->attach($id);

        $usuario->password = $request['password'];

        Notification::send($usuario, new UsuarioCadastradoNotification($usuario));

        return redirect()->back()->with(['success' => 'Usuário cadastrado com sucesso.']);
    }

    public function definirPresidente(Request $request) {
        $concurso = Concurso::find($request->concurso); 
        $this->authorize('operacoesUserBanca', $concurso);

        foreach ($concurso->chefeDaBanca as $user) {
            if ($request->presidente == $user->id) {
                $concurso->chefeDaBanca()->updateExistingPivot($user->id, ['chefe' => true]);
            } else {
                $concurso->chefeDaBanca()->updateExistingPivot($user->id, ['chefe' => false]);
            }
        }
        
        return redirect()->back()->with(['success' => 'Presidente da banca examinadora salvo com sucesso.']);
    }
}
