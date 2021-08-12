@extends('templates.template-principal')
@section('content')
    <div class="container" style="margin-top: 5rem; margin-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow bg-white style_card_container">
                    <div class="card-header d-flex justify-content-between bg-white" id="style_card_container_header">
                        <div class="form-group">
                            <h6 class="style_card_container_header_titulo">Candidatos</h6>
                            <h6 class="" style="font-weight: normal; color: #909090; margin-top: -10px; margin-bottom: -15px;">Meus concursos > Visualizar candidatos</h6>
                        </div>
                        <div class="form-group">
                            <div class="style_card_container_header_campo_obrigatorio">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-filtros">Filtrar</button>
                                @if($inscricoes->count() > 0)
                                    <a class="btn btn-primary" href="{{route('baixar.documentos.todos.candidatos',['concurso_id' => $concurso->id])}}">
                                        <div class="btn-group">
                                            <img src="{{asset('img/icon_arquivo_download_branco.svg')}}" style="width:15px">
                                            <h6 style="margin-left: 5px; margin-top:1px; margin-bottom: 1px; color:#fff">Baixar documentos dos candidatos</h6>
                                        </div>
                                    </a>
                                @endif
                                @if($request->filtro != null)
                                    <a type="button" class="btn btn-secondary" href="{{route('show.candidatos.concurso', $concurso->id)}}">Limpar filtros</a>
                                @endif
                                @if(auth()->user()->role != "presidenteBancaExaminadora")
                                    <a type="button" class="btn btn-success" href="{{route('inscricao.chefe.concurso', ['concurso' => $concurso->id])}}">Inscrever candidato</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @error('error')
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{ $message }}</p>
                                    </div>
                                </div>
                            </div>
                        @enderror
                    </div>
                    @if($inscricoes->count() > 0)
                        <div class="card-body">
                            @if(session('mensage'))
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 5px;">
                                        <div class="alert alert-success" role="alert">
                                            <p>{{session('mensage')}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 5px;">
                                        <div class="alert alert-success" role="alert">
                                            <p>{{session('success')}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <table class="table table-hover table-responsive-md">
                                <thead>
                                    <tr class="shadow-sm" style="border: 1px solid #dee2e6">
                                        <th scope="col" class="tabela_container_cabecalho_titulo">Posição</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo" style="text-align:left">Nome / Vaga</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo">Data e hora</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo" style="text-align:center">Status</th>
                                        <th scope="col" class="tabela_container_cabecalho_titulo">Avaliar</th>
                                    </tr>
                                </thead>
                                <tbody id="candidatos">
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($inscricoes as $inscricao)
                                        <tr>
                                            <th scope="row" id="tabela_container_linha"  style="text-align: center;">{{$cont}}</th>
                                            <td id="tabela_container_linha">
                                                <div class="form-group">
                                                    <h6 style="font-weight: normal;">{{$inscricao->user->nome}}</h6>
                                                    <h6 style="font-weight: normal; color:#909090; font-style: italic; font-size:14px; margin-top:-5px">{{ $inscricao->vaga->nome }}</h6>
                                                </div>
                                            </td>
                                            <td id="tabela_container_linha" style="text-align: center">
                                                 {{$inscricao->created_at->format('d/m/Y - h:m:s')}}
                                            </td>
                                            <td id="tabela_container_linha" style="text-align: center">
                                                @if($inscricao->status == "aprovado")
                                                    <img src="{{asset('img/icon_aprovado_verde.svg')}}" alt="..." width="25px" data-toggle="tooltip" data-placement="top" title="Candidato aprovado">
                                                    @if($inscricao->arquivos != null)
                                                        <img src="{{asset('img/icons-document-blue.png')}}" alt="..." width="25px" data-toggle="tooltip" data-placement="top" title="Candidato enviou os documentos">
                                                    @endif
                                                @elseif($inscricao->status == "reprovado")
                                                    <img src="{{asset('img/icon_reprovado_vermelho.svg')}}" alt="..." width="25px" data-toggle="tooltip" data-placement="top" title="Candidato reprovado">
                                                @elseif($inscricao->status == "Aguardando pagamento")
                                                    <img src="{{asset('img/icon_pagamento_pendente_colorido.svg')}}" alt="..." width="55px" data-toggle="tooltip" data-placement="top" title="Aguardando pagamento">
                                                @else
                                                    <img src="{{asset('img/icon_pendente_colorido.svg')}}" alt="..." width="25px" data-toggle="tooltip" data-placement="top" title="Pendente">
                                                @endif
                                            </td>
                                            <td id="tabela_container_linha" style="text-align: center;">
                                                <div class="btn-group">
                                                    @if (Auth::user()->role == "admin" || Auth::user()->role == "chefeSetorConcursos")
                                                        <div class="btn-group">
                                                            <div>
                                                                <button class="btn btn-primary" onclick ="location.href='{{ route('candidato.inscricao', $inscricao->id) }}'">
                                                                    Inscrição
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($inscricao->status == "aprovado")
                                                        <div class="btn-group">
                                                            <div style="margin-left: 5px">
                                                                @if ($inscricao->concurso->data_inicio_envio_doc <= date('Y-m-d', strtotime(now())))
                                                                    <a class="btn btn-primary" href="{{route('avalia.documentos.inscricao', $inscricao->id)}}">
                                                                        Prova de Títulos
                                                                    </a>
                                                                @else
                                                                    <button class="btn btn-primary" disabled>
                                                                        Prova de Títulos
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @php
                                        $cont = $cont +1;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="form-row" style="text-align: center;">
                                <div class="col-md-12" style="margin-top: 5rem; margin-bottom: 10rem;">
                                    <img src="{{asset('img/img_default_meus_concursos.svg')}}" alt="Imagem default" width="190px">
                                    <h6 class="style_campo_titulo" style="margin-top: 20px;">Nenhum candiadato inscreveu-se para esse concurso.</h6>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-filtros" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Filtrar candidatos</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="form-filtros" method="GET" action="{{route('show.candidatos.concurso', $concurso->id)}}">
                    <input type="hidden" name="filtro" value="1">
                    <input type="hidden" name="concurso_id" value="{{$concurso->id}}">
                    <div class="form-row">
                        <div id="check-input-cpf" class="col-sm-4 form-group">
                            <input id="check_cpf" type="checkbox" class="input-search" name="check_cpf" onchange="exibirCampo(this, 'input-cpf')" @if($request->check_cpf) checked @endif>
                            <label for="check_cpf">Por CPF.</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div id="input-cpf" class="col-sm-6 form-group" style="{{$request->cpf != null ? 'display: block;' : 'display: none;'}}">
                            <input type="text" class="form-control input-search cpf" name="cpf" placeholder="Digite o CPF" value="{{$request->cpf != null ? $request->cpf : ""}}">
                            <small>Obs.: digitar somente números.</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" form="form-filtros">Filtrar</button>
            </div>
          </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.cpf').mask('00000000000');
        });

        function exibirCampo(input, id) {
            if (input.checked) {
                document.getElementById(id).style.display = "block";
            } else {
                document.getElementById(id).style.display = "none";
            }
        }
        function busca(nome) {
            var candidatos = document.getElementById('candidatos').children;
            if(nome.length > 2) {
                for(var i = 0; i < candidatos.length; i++) {
                    var nomeLinha = candidatos[i].children[1].children[0].children[0].textContent;
                    console.log(nomeLinha);
                    if(nomeLinha.substr(0).indexOf(nome) >= 0) {
                        candidatos[i].style.display = "";
                    } else {
                        candidatos[i].style.display = "none";
                    }
                }
            } else {
                for(var i = 0; i < candidatos.length; i++) {
                    candidatos[i].style.display = "";
                }
            }
        }
    </script>
@endsection
