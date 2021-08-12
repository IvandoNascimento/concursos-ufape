@extends('templates.template-principal')
@section('content')
<div class="container" style="margin-top: 5rem; margin-bottom: 8rem;">
    <div class="form-row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow bg-white style_card_container">
                <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                    <div class="form-group">
                        <h6 class="style_card_container_header_titulo">Banca examinadora do(a) {{$concurso->titulo}}</h6>
                        <h6 class="" style="font-weight: normal; color: #909090; margin-top: -10px; margin-bottom: -15px;">Meus concursos > Banca examinadora</h6>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle style_card_container_header_campo_obrigatorio" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top:10px; cursor:pointer; color: white;">Opções</button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a id="criar-user" class="dropdown-item" data-toggle="modal" data-target="#create-user-banca" >Criar membro de banca examinadora</a>
                            <a id="selecionar-user" class="dropdown-item" href="#" data-toggle="modal" data-target="#presidente-banca" >Selecionar presidente da banca</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="col-md-12">
                            <div class="alert alert-success" role="alert">
                                <p>{{session('success')}}</p>
                            </div>
                        </div>
                    @endif
                    @error('error')
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 5px;">
                                <div class="alert alert-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </div>
                            </div>
                        </div>
                    @enderror
                    <table class="table table-bordered table-hover tabela_container table-responsove-md">
                        <thead>
                            <tr>
                                <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Nome</th>
                                <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Sobrenome</th>
                                <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">E-mail</th>
                                <td scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Presidente da banca</td>
                                <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                            @forelse ($membrosDoConcurso as $user)
                                <tr>
                                    <td id="tabela_container_linha">
                                        {{ $user->nome }}
                                    </td>
                                    <td id="tabela_container_linha">
                                        {{ $user->sobrenome }}
                                    </td>
                                    <td id="tabela_container_linha">
                                        {{ $user->email }}
                                    </td>
                                    <td id="tabela_container_linha" style="text-align: center">
                                        @if ($user->concursosChefeBanca('concurso_id', $concurso->id)->first()->pivot->chefe)
                                            <img src="{{asset('img/star.png')}}" width="25px" alt="Presidente da banca">
                                        @endif
                                    </td>
                                    <td id="tabela_container_linha" style="text-align: center;">
                                        <div class="btn-group">
                                            <div>
                                                <button class="btn btn-danger"onclick ="this.disabled=true;location.href='{{ route('concurso.remover.banca', ['user' => $user->id, 'concurso' => $concurso->id]) }}'">
                                                    Remover da banca
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <td id="tabela_container_linha">
                                    Sem usuários cadastrados ainda
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- <div class="card-footer" style="background-color: #fff; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <div><h6 style="font-weight: bold">Legenda:</h6></div>
                    <div class="form-row">
                        <div style="margin: 5px">
                            <button class="btn btn-info" class="btn btn-success" style="margin-right: 10px" disabled>
                            <img class="card-img-left example-card-img-responsive" src="{{asset('img/icon_editar.svg')}}" width="16px"/>
                            </button> Editar Usuário</div>
                        <div style="margin: 5px">
                            <button class="btn btn-danger" class="btn btn-success" style="margin-right: 10px" disabled>
                            <img class="card-img-left example-card-img-responsive" src="{{asset('img/icon_lixeira.svg')}}" width="16px"/>
                            </button> Deletar Usuário</div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="form-row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-11">
            <div class="card shadow bg-white style_card_container">
                <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                    <div class="form-group">
                        <h6 class="style_card_container_header_titulo">Usuários de banca examinadora cadastrados</h6>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover tabela_container table-responsove-md">
                        <thead>
                            <tr>
                                <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Nome</th>
                                <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Sobrenome</th>
                                <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">E-mail</th>
                                <th scope="col" class="tabela_container_cabecalho_titulo" style="width: 100%;">Ações</th>
                            </tr>
                        </thead>
                        <tbody >
                            @forelse ($usuariosMembros as $user)
                                <tr>
                                    <td id="tabela_container_linha">
                                        {{ $user->nome }}
                                    </td>
                                    <td id="tabela_container_linha">
                                        {{ $user->sobrenome }}
                                    </td>
                                    <td id="tabela_container_linha">
                                        {{ $user->email }}
                                    </td>
                                    <td id="tabela_container_linha" style="text-align: center;">
                                        <div class="btn-group">
                                            <div>
                                                <button class="btn btn-info" onclick ="this.disabled=true;location.href='{{ route('concurso.adicionar.banca', ['user' => $user->id, 'concurso' => $concurso->id]) }}'">
                                                    Adicionar a banca
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <td id="tabela_container_linha">
                                    Sem usuários cadastrados ainda
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- <div class="card-footer" style="background-color: #fff; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <div><h6 style="font-weight: bold">Legenda:</h6></div>
                    <div class="form-row">
                        <div style="margin: 5px">
                            <button class="btn btn-info" class="btn btn-success" style="margin-right: 10px" disabled>
                            <img class="card-img-left example-card-img-responsive" src="{{asset('img/icon_editar.svg')}}" width="16px"/>
                            </button> Editar Usuário</div>
                        <div style="margin: 5px">
                            <button class="btn btn-danger" class="btn btn-success" style="margin-right: 10px" disabled>
                            <img class="card-img-left example-card-img-responsive" src="{{asset('img/icon_lixeira.svg')}}" width="16px"/>
                            </button> Deletar Usuário</div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create-user-banca" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Criar usuário de banca examinadora</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('user.create.banca', ['concurso' => $concurso->id])}}">
                @csrf
                @if(session('error'))
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            <p>{{session('error')}}</p>
                        </div>
                    </div>
                @endif
                <input type="hidden" name="user_new" value="0">
                <input type="hidden" name="role" value="presidenteBancaExaminadora">
                <input type="hidden" name="concurso" value="{{$concurso->id}}">
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="nome" class="style_campo_titulo">Nome <span style="color: red; font-weight: bold;">*</span></label>
                        <input type="text" class="form-control style_campo @error('nome') is-invalid @enderror" id="nome" name="nome"
                            placeholder="Digite seu nome" value="{{ old('nome') }}" required/>
                        @error('nome')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="sobrenome" class="style_campo_titulo">Sobrenome <span style="color: red; font-weight: bold;">*</span></label>
                        <input type="text" class="form-control style_campo @error('sobrenome') is-invalid @enderror" id="sobrenome" name="sobrenome"
                            value="{{ old('sobrenome') }}" placeholder="Digite seu sobrenome" required />
                        @error('sobrenome')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <h6 class="style_card_container_header_subtitulo">Acesso ao sistema</h6>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 form-group">
                        <label for="email" class="style_campo_titulo">E-mail <span style="color: red; font-weight: bold;">*</span></label>
                        <input type="email" class="form-control style_campo @error('email') is-invalid @enderror" id="email" name="email"
                            placeholder="Digite seu e-mail" value="{{ old('email') }}" required />
                        @error('email')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="password" class="style_campo_titulo">Senha <span style="color: red; font-weight: bold;">*</span></label>
                        <input type="password" class="form-control style_campo @error('password') is-invalid @enderror" id="password" name="password"
                            placeholder="Digite sua senha" required autocomplete="new-password"/>
                        @error('password')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="password_confirmation" class="style_campo_titulo">Confirmar senha <span style="color: red; font-weight: bold;">*</span></label>
                        <input type="password" class="form-control style_campo" id="password_confirmation" name="password_confirmation"
                            placeholder="Confirme sua senha" required autocomplete="new-password" />
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom: 5px;">
                    <hr>
                </div>
                <div class="col-md-12 form-group" style="margin-bottom: 9px;">
                    <button class="btn btn-success shadow-sm" style="width: 100%;" id="submeterFormBotao">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<div class="modal fade" id="presidente-banca" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Selecionar presidente da banca examinadora</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="selecionar-presidente-form" method="POST" action="{{route('user.presidente.banca', ['concurso' => $concurso->id])}}">
                @csrf
                <div class="col-md-12 form-group">
                    <input type="hidden" name="concurso" value="{{$concurso->id}}">
                    <label for="presidente">Presidente</label>
                    <select name="presidente"  class="form-control" id="presidente" required>
                        <option value="" selected disabled>-- Selecione o presidente --</option>
                        @foreach ($membrosDoConcurso as $user)
                            <option value="{{$user->id}}">{{$user->nome . " " . $user->sobrenome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 form-group" style="margin-bottom: 9px;">
                    <button class="btn btn-success shadow-sm" style="width: 100%;" id="submeterFormBotao" form="selecionar-presidente-form">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
@if(old('user_new') != null)
<script>
    $(document).ready(function($) {
        $('#create-user-banca').modal('show');
    });
</script>
@endif
@endsection
